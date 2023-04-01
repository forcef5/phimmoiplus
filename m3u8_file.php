<?php
require_once('vendor/autoload.php');
use DiDom\Document;
/* m3u8($id_link_m3u8,$file_name,$folder)
Hàm thực hiện tạo file m3u8 lưu trên server
$id_link_m3u8 là link tới  = 'https://sotrim.topphimmoi.org/hlspm/75657b71e9fff83943f653eb45bd0c7f';
$file_name : Đặt tên tập tin của phim đó
$folder : nới chứa là phimle hay phimbo
*/

function m3u8($id_link_m3u8,$file_name,$folder) {
    $iniPlayers = ['https://sotrim.topphimmoi.org/hlspm/','https://dash.megacdn.xyz/hlspm/','https://so-trym.phimchill.net/dash/'];
    $i=0;
    foreach ($iniPlayers as $link_play) {
        $i+=1;
//        if ($link_play=='https://sotrim.topphimmoi.org/hlspm/' or  $link_play=='https://dash.megacdn.xyz/hlspm/') {
        if ($link_play=='https://sotrim.topphimmoi.org/hlspm/') {
            $link_m3u8 = $link_play . $id_link_m3u8;
            echo $link_m3u8;
            echo "\n";
            $m3u8_file = new Document($link_m3u8, true);
            if (preg_match('/"}],"targetDuration":(.+?),"/', $m3u8_file, $target_m3u8)){

                preg_match('/{"2048p":{"allowCache":true,"discontinuityStarts":\[\],"segments":\[{"du":"(.+?)"}\],"targetDuration"/', $m3u8_file, $m3u8_file_edited);
                $m3u8_file = str_replace('"},{"du":"', "\n#EXTINF:", $m3u8_file_edited[1]);
                $m3u8_file = str_replace('","link":"', "\n", $m3u8_file);

                $myfile = fopen($folder . "/" . $file_name . "_sv_" . $i . ".m3u8", "w");
                echo $m3u8_path = $folder . "/" . $file_name . "_sv_" . $i . ".m3u8\n";
                $txt = "#EXTM3U\n#EXT-X-VERSION:3\n#EXT-X-TARGETDURATION:" . $target_m3u8[1] . "\n#EXT-X-MEDIA-SEQUENCE:0\n#EXTINF:";
                fwrite($myfile, $txt);
                fwrite($myfile, $m3u8_file . "\n#EXT-X-ENDLIST");
                fclose($myfile);
                sleep(1);
                echo "Đã tạo xong file: " . $file_name . "_sv_" . $i . ".m3u8\n";
            }
            else {
                echo "Lỗi không lấy được ID của link m3u8\n";
            }

        }
        elseif ($link_play == 'https://so-trym.phimchill.net/dash/') {
            $link_m3u8 = $link_play . $id_link_m3u8 . "/index.m3u8";
            echo $link_m3u8;
            echo "\n";
            $m3u8_file = new Document($link_m3u8, true);
            $m3u8_file = str_replace('<html><body><p>','',$m3u8_file);
            $m3u8_file = str_replace('</p></body></html>','',$m3u8_file);
            $m3u8_file = str_replace('%2F', '/', $m3u8_file);
            $m3u8_file = str_replace('%3A', ':', $m3u8_file);
            $m3u8_file = str_replace('https://images2-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&amp;refresh=604800&amp;url=', '', $m3u8_file);
            $myfile = fopen($folder . "/" . $file_name . "_sv_" . $i . ".m3u8", "w");
            fwrite($myfile, $m3u8_file);
            fclose($myfile);
            echo "Đã tạo xong file: " . $file_name . "_sv_" . $i . ".m3u8\n";

        }
        else{
            echo 'BỎ QUA TRƯỜNG HỢP NÀY: '.$link_m3u8."\n";
        }
    }
}

?>