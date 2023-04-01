<?php
require_once('vendor/autoload.php');
/*Mẫu lấy PHIMLE khi đã có link play dạng
https://phimmoichillb.net/xem/tay-dam-huyen-thoai-3-tap-full-pm108451
 *
 */
use DiDom\Document;

function m3u8_link2id($m3u8_link){
    //Cần truyền vào ID của phim (.*?)pm108451 tách lấy sau pm được : 108451
    $id_phim =explode('-pm',$m3u8_link);
    $id_phim = $id_phim[1];
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'https://phimmoichillb.net/chillsplayer.php',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/111.0.0.0 Safari/537.36',
        CURLOPT_POST => 1,
        CURLOPT_SSL_VERIFYPEER => false, //Bỏ kiểm SSL
        CURLOPT_TIMEOUT =>300,
        CURLOPT_POSTFIELDS => http_build_query(array(
            'qcao' => $id_phim,

        ))
    ));
    $resp = curl_exec($curl);
    if (preg_match('/(.*)iniPlayers\("(.*)"/', $resp, $idm3u8)) {
//        echo 'Tim thay iniPlayers <br>';
//
//        $link_m3u8_sv1 = 'https://sotrim.topphimmoi.org/hlspm/' . $idm3u8[2];
//        $link_m3u8_sv2 = 'https://dash.megacdn.xyz/hlspm/' . $idm3u8[2];
//        echo $link_m3u8_sv1."<br>\n".$link_m3u8_sv2."<br>\n";
//        echo "Kết thúc lệnh tìm id_m3u8\n";
//        echo 'Lấy được $m3u8_id là:'.$idm3u8[2]."\n";
        sleep(0.5);
        return $idm3u8[2];

        // sv1 https://sotrim.topphimmoi.org/hlspm/fcdcdb2a90d8285a58dc2217b5fac03c
        // sv2 https://dash.megacdn.xyz/hlspm/fcdcdb2a90d8285a58dc2217b5fac03c
        // sv3 https://so-trym.phimchill.net/dash/fcdcdb2a90d8285a58dc2217b5fac03c/index.m3u8
        // sv4 https://dash.megacdn.xyz/dast/fcdcdb2a90d8285a58dc2217b5fac03c/index.m3u8

    } else {
        echo $m3u8_link."\n";
        echo "Tìm ID của link m3u8 bị lỗi: Mạng lag, hoặc server phimmoiplus.net lỗi\n";
        $myfile = fopen("phimmoiplus.net_log_err.txt", "w");
        fwrite($myfile,$m3u8_link ."\n");

        return 'Lỗi idm3u8[2]';
    }

}
?>