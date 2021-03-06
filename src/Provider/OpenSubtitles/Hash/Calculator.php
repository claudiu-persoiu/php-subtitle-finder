<?php

namespace Provider\OpenSubtitles\Hash;

class Calculator
{
    public function calculateHash(\SplFileInfo $fileInfo)
    {
        $handle   = fopen($fileInfo->getPathname(), "rb");
        $fileSize = $fileInfo->getSize();

        $hash = array(
            3 => 0,
            2 => 0,
            1 => ($fileSize >> 16) & 0xFFFF,
            0 => $fileSize & 0xFFFF
        );

        for ($i = 0; $i < 8192; $i++) {
            $tmp  = $this->readUINT64($handle);
            $hash = $this->addUINT64($hash, $tmp);
        }

        $offset = $fileSize - 65536;
        fseek($handle, $offset > 0 ? $offset : 0, SEEK_SET);

        for ($i = 0; $i < 8192; $i++) {
            $tmp  = $this->readUINT64($handle);
            $hash = $this->addUINT64($hash, $tmp);
        }

        fclose($handle);

        return $this->uINT64FormatHex($hash);
    }

    private function readUINT64($handle)
    {
        $u = unpack("va/vb/vc/vd", fread($handle, 8));

        return array(0 => $u["a"], 1 => $u["b"], 2 => $u["c"], 3 => $u["d"]);
    }

    private function addUINT64($a, $b)
    {
        $o = array(0 => 0, 1 => 0, 2 => 0, 3 => 0);

        $carry = 0;
        for ($i = 0; $i < 4; $i++) {
            if (($a[$i] + $b[$i] + $carry) > 0xffff) {
                $o[$i] += ($a[$i] + $b[$i] + $carry) & 0xffff;
                $carry = 1;
            } else {
                $o[$i] += ($a[$i] + $b[$i] + $carry);
                $carry = 0;
            }
        }

        return $o;
    }

    private function uINT64FormatHex($n)
    {
        return sprintf("%04x%04x%04x%04x", $n[3], $n[2], $n[1], $n[0]);
    }
}