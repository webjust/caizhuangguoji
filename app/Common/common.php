<?php
function replace_img_url($list, $type = 0)
{
    $domain = "https://static.caizhuangguoji.com";
    if ($type === 0) {
        foreach ($list as $k => $v) {
            if ($v['g_picture']) {
                $list[$k]['g_picture'] = str_replace("/Public/Uploads", "", $domain . $v['g_picture']);
            }
            if ($v['sp_picture']) {
                $list[$k]['sp_picture'] = str_replace("/Public/Uploads", "", $domain . $v['sp_picture']);
            }
        }
    } elseif ($type === "brand_log") {
        $list['gb_logo'] = $domain . str_replace("/Public/Uploads", "", $list['gb_logo']);
    } elseif ($type === "g_picture") {
        $list['g_picture'] = $domain . str_replace("/Public/Uploads", "", $list['g_picture']);
    }
    return $list;
}

function replace_img_path($img_path)
{
    $domain = "https://static.caizhuangguoji.com";
    if (!$img_path) {
        return '';
    }
    return $domain . str_replace("/Public/Uploads", "", $img_path);
}

function show_data($data = array(), $info, $stats, $type = 'json')
{
    $arr = array(
        'data' => $data,
        'info' => $info,
        'status' => $stats
    );
    if ($type == 'arr') {
        return $arr;
    }
    return json_encode($arr);
}