<?php
/**
 * Created by PhpStorm.
 * User: outstudio
 * Date: 16/5/29
 * Time: 上午10:12
 */

require './fetch.php';
;



$jsPattern="/<script.*?src=['\"](.*?\.js)['\"][>|\/>](?:<\/script>)?/";
$cssPattern="/<[link|Link].*?href=['\"](.*?\.css)['\"].*?[>|\/>]/";
$imgPattern="/<img.*?src=['\"](.*?)['\"].*?[>|\/>]/";
$backgroundPattern="/background:.*?url\(['\"](.*?)['\"]\)/";
$urlPattern="/url\(['|\"]?(.*?)['|\"]?\)/";
$dataImagePattern="/.*?data\:image(.*)/";
$dirPattern="/(.*)\/.*?/";
$filePattern="/.*\/(.*)?/";
$remotePattern="/http:\/\/(.*?)\//";
$aInPagePattern="/<a.*?(?:>)(.*?)(?:<\/a>)/";
$emInPagePattern="/<em.*?class=\"current\">(.*?)<\/em>/";

$url = "http://www.oschina.net/project/lang/28/javascript?tag=0&os=0&sort=view&p=2";
$serUrl="http://www.oschina.net/search?scope=project&q=%E5%8F%AF%E8%A7%86%E5%8C%96%E5%BA%93";
$domain="https://github.com/search?";
$gitUrl="https://github.com/search?utf8=%E2%9C%93&q=%E5%8F%AF%E8%A7%86%E5%8C%96&type=Repositories&ref=searchresults";
$re=get_content($gitUrl);
$fp=fopen("./git.html","w");
fwrite($fp,$re);
fclose($fp);
$pageNationPattern="/<div class=[\'|\"]pagination[\'|\"].*?>(.*)?<\/div>/";
locatePagination($re,"pagination");

function locatePagination($re,$className)
{

    global $pageNationPattern;
    global $domain;
    global $aInPagePattern;
    global $emInPagePattern;
    $row=array();
    preg_match($pageNationPattern,$re,$matched);
    if($matched)
    {
        $lastPage="";
        preg_match_all($aInPagePattern,$matched[1],$pages);
        if($pages)
        {
            echo "matched pages========== ".count($pages[1])."\n";
            findCategory("1","https://github.com/search?p=1&q=%E5%8F%AF%E8%A7%86%E5%8C%96&type=Repositories&utf8=%E2%9C%93");
            foreach($pages[1] as $i=>$page)
            {
                if($i==(count($pages[1])-2))
                {
                    echo "lastPage=====".$page."\n";
                    $lastPage=$page;
                    break;
                }
            }
            for($i=2;$i<=$lastPage;$i++)
            {
                findCategory($i,$domain."p=".$i."&q=%E5%8F%AF%E8%A7%86%E5%8C%96&ref=searchresults&type=Repositories&utf8=%E2%9C%93");
            }
        }
    }
}

//class localte the div with className=$class
function findCategory($pageNum,$url){
    if($pageNum%7==0)
        //sleep(30);
    if($pageNum%9==0)
        //sleep(60);
    echo "pageNum===============".$pageNum."\n";
    $content=get_content($url);
    preg_match_all("/<div class=\"repo-list-stats\">\s*(.*?)\s*<a/",$content,$items);
    if($items)
    {
        $fp=fopen("./collect/git/category.txt","a+");
        foreach($items[1] as $item)
        {
            if($item!="")
            {
                echo "item=====" . strtolower($item) . "\n";
                fwrite($fp,strtolower($item)." ");
            }
        }
        fclose($fp);
    }
    //    $content='<div class="repo-list-stats">
//    JavaScript
//    <a class="repo-list-stat-item tooltipped tooltipped-s" href="fex-team/kityminder-core/stargazers" aria-label="Stargazers">
//      <svg aria-hidden="true" class="octicon octicon-star" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M14 6l-4.9-0.64L7 1 4.9 5.36 0 6l3.6 3.26L2.67 14l4.33-2.33 4.33 2.33L10.4 9.26 14 6z"></path></svg>
//    100
//    </a>
//    <a class="repo-list-stat-item tooltipped tooltipped-s" href="fex-team/kityminder-core/network" aria-label="Forks">
//      <svg aria-hidden="true" class="octicon octicon-git-branch" height="16" version="1.1" viewBox="0 0 10 16" width="10"><path d="M10 5c0-1.11-0.89-2-2-2s-2 0.89-2 2c0 0.73 0.41 1.38 1 1.72v0.3c-0.02 0.52-0.23 0.98-0.63 1.38s-0.86 0.61-1.38 0.63c-0.83 0.02-1.48 0.16-2 0.45V4.72c0.59-0.34 1-0.98 1-1.72 0-1.11-0.89-2-2-2S0 1.89 0 3c0 0.73 0.41 1.38 1 1.72v6.56C0.41 11.63 0 12.27 0 13c0 1.11 0.89 2 2 2s2-0.89 2-2c0-0.53-0.2-1-0.53-1.36 0.09-0.06 0.48-0.41 0.59-0.47 0.25-0.11 0.56-0.17 0.94-0.17 1.05-0.05 1.95-0.45 2.75-1.25s1.2-1.98 1.25-3.02h-0.02c0.61-0.36 1.02-1 1.02-1.73zM2 1.8c0.66 0 1.2 0.55 1.2 1.2s-0.55 1.2-1.2 1.2-1.2-0.55-1.2-1.2 0.55-1.2 1.2-1.2z m0 12.41c-0.66 0-1.2-0.55-1.2-1.2s0.55-1.2 1.2-1.2 1.2 0.55 1.2 1.2-0.55 1.2-1.2 1.2z m6-8c-0.66 0-1.2-0.55-1.2-1.2s0.55-1.2 1.2-1.2 1.2 0.55 1.2 1.2-0.55 1.2-1.2 1.2z"></path></svg>
//    71
//    </a>
//  </div>';
//    $content=" <div class=\"repo-list-stats\">dwdwd</div>";
}

