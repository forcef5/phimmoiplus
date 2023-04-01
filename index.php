<?php
/*Mẫu lấy tat ca cac phim le o phimmoiplus.net
 */
date_default_timezone_set('Asia/Ho_Chi_Minh');
include ('m3u8_file.php');
include ('m3u8_link.php');
require_once('vendor/autoload.php');

use DiDom\Document;

$url = 'https://phimmoichillb.net/list/phim-le/';
for ($page = 1; $page<=368; $page++) {
    echo "Vòng lặp thứ $page <br>";
    ListPhim_Page($url,$page,'phimle');
}


function ListPhim_Page($url,$page, $folder)
{
    $html = new \DiDom\Document($url."-".$page, true);
    $data_page = $html->find('div#binlist')[0]->find('ul[class="list-film horizontal"]')[0];

    $listphims = $data_page->find('li[class="item small"]');
    foreach ($listphims as $listphim) {
        $title_phim = $listphim->find('a')[0]->getAttribute('title');
        echo "<h3>" . mb_strtoupper($title_phim) . "</h3><br>\n";
        $img_phim = $listphim->find('a')[0]->find('img')[0]->getAttribute('src');
        $img_phim = str_replace('%2F', '/', $img_phim);
        $img_phim = str_replace('%3A', ':', $img_phim);
        $img_phim = str_replace('https://chill-focus-opensocial.googleusercontent.com/gadgets/proxy?container=focus&refresh=604800&url=', '', $img_phim);
        echo $img_phim . "<br>\n";
        $link_phim_info = $listphim->find('a')[0]->getAttribute('href');
        echo $link_phim_info . "<br>\n";
//        echo '<img src="'.$img_phim.'" alt="Example" width="400" height="400">';
        echo '<img src="' . $img_phim . '" style="height: 280px;"<br>';
        $phim_page_info = new Document($link_phim_info, true);
        sleep(0.5);
        $theloais = $phim_page_info->find('ul[class="entry-meta block-film"]')[0]->text();
        if(preg_match('/"Thể loại:  "(.+?)  Đạo diễn"/',$theloais,$theloai)){
           echo "Thể loại phim: ". $theloai;
        }
//        sleep(30000);
        $noidungphim = $phim_page_info->find('div#film-content')[0]->text();
        $noidungphim = "<h3>Tóm tắt nội dung phim:</h3>" . explode('Full HD Vietsub Thuyết Minh', $noidungphim)[1];
        echo $noidungphim . "\n";
        if(preg_match('#a href="https://phimmoichillb.net/xem/(.*?)"#',$phim_page_info,$check_xem)){
            echo "BẮT ĐẦU TÌM LINK M3U8\n";
            $link_play = $phim_page_info->find('ul[class="list-button"]')[0]->find('a')[1]->getAttribute('href');
            $file_name = str_replace('https://phimmoichillb.net/xem/', '', $link_play);
            echo "<br>\n" . $link_play . "<br><hr/>\n";
            if (m3u8_link2id($link_play) == '') {
                echo "BỎ QUA: Tìm ID của link m3u8 bị lỗi: Mạng lag, hoặc server phimmoiplus.net lỗi\n";
            } else {
                $id_link_m3u8 = m3u8_link2id($link_play);
                m3u8($id_link_m3u8, $file_name, $folder);
                $myfile = fopen("phimmoiplus.net_log.txt", "a");
                fwrite($myfile, $link_play . "\n");
                echo 'Đang chạy page: ' . $page."\n";
                sleep(2);

            }
        }
        else {
            echo "PHIM MỚI CHỈ CÓ TRAILER - KHÔNG TÌM THẤY LINK XEM\n";
        }
    }
}
?>
