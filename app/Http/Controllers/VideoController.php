<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function show($filename)
    {
        $path = storage_path('app/videos/' . $filename);
    
        if (!file_exists($path)) {
            abort(404);
        }
    
        $size = filesize($path);
        $file = fopen($path, "rb");
    
        $start = 0;
        $end = $size - 1;
    
        if (isset($_SERVER['HTTP_RANGE'])) {
            $range = $_SERVER['HTTP_RANGE'];
            $range = str_replace('bytes=', '', $range);
            $range = explode('-', $range);
    
            $start = intval($range[0]);
            if (isset($range[1]) && is_numeric($range[1])) {
                $end = intval($range[1]);
            }
        }
    
        $length = $end - $start + 1;
    
        fseek($file, $start);
    
        $headers = [
            'Content-Type' => 'video/mp4',
            'Content-Length' => $length,
            'Accept-Ranges' => 'bytes',
            'Content-Range' => "bytes $start-$end/$size",
        ];
    
        return response()->stream(function () use ($file, $length) {
            $buffer = 1024 * 8;
            while (!feof($file) && $length > 0) {
                $read = ($length > $buffer) ? $buffer : $length;
                $length -= $read;
                echo fread($file, $read);
                flush();
            }
            fclose($file);
        }, 206, $headers);
    }
    
}
