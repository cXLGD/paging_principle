<?php

/** 
 * 分页原理
 * $integer     $current    当前页码
 * $integer     $count      查询到的数据总条数
 * $integer     $limit      每个页面显示的条数
 * $integer     $size       显示有多少个分页页码 1 2 3 4 5
 * $string      $class      加载自己的样式类名
*/ 
function page($current, $count, $limit, $size, $class='my-page'){
    //定义一个空字符串，用于拼接分页html代码
    $str = '';
    
    if($count > $limit){ //如果数据条数大于每页显示的条数，才分页
        //div可以不要，类名直接加到ul上
        $str .= "<div class='{$class}'><ul>";

        // 首页
        if($current == 1){
            //如果当前在第一页，不可点击
            $str .= "<li class='prev'>&lt;</li>";
        }else{
            //可点击的上一页
            $str .= "<li class='prev'><a href='?page=".($current-1)."'>&lt;</a></li>";
            //跳转到第一页
            $str .= "<li><a href='?page=1'>首页</a></li>";
        }
        
        // 计算总页数，用向上取整，不够的再加多一页显示
        $pages = ceil($count/$limit);
        

        // 比较值，分页显示的个数的一半
        $compare = floor($size/2);
        if($current <= $compare){
            //如果当前页码小于等于比较值，上面例子的cur=1,cur=2
            //第一个页码数为1
            $start = 1;
            //最后一个如果大于规定的个数，则显示规定的个数，否则显示现实小的个数
            $end = $pages > $size ? $size : $pages;
            
        }else if($current > $pages - $compare){
            //如果当前页码数大于查询到的总页数减去比较值的话,上面例子的cur=3,cur=4,cur=5
            //解决第一个页码数小于1的办法
            $start = ($pages - $size + 1) < 1 ? 1 : ($pages - $size + 1);
            //最后一个为查询到的数字
            $end = $pages;
            
        }else{
            //上面例子的最后两个
            $start = $current - $compare;
            $end = $current + $compare;
        }

        //循环输出
        for($i = $start; $i<=$end; $i++){
            if($i == $current){
                //如果是当前页的话，加上active样式
                $str .= "<li class='active'><a>{$i}</a></li>";
            }else{
                $str .= "<li><a href='?page={$i}'>{$i}</a></li>";
            }
        }

        if($current == $pages){
            // 不可点击
            $str .= "<li class='next'>&gt;</li>";
        }
        else{
            //跳转到最后一页
            $str .= "<li><a href='?page=".$pages."'>尾页</a></li>";
            //可以点击的下一页
            $str .= "<li class='prev'><a href='?page=".($current+1)."'>&gt;</a></li>";
        }

        $str .= "</ul></div>";

        return $str;
    }