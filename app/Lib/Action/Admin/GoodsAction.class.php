<?php

class GoodsAction extends Action
{
    public function lists()
    {
        header("Content-Type:text/html; charset=utf-8");
        $GoodsViewModel = new GoodsViewModel();
        $condition = array();

        $data = $this->_get();
        unset($data['_URL_']);
        unset($data['p']);

        if ($data['keywords']) {
            $condition['GoodsInfo.g_name'] = array('like', "%" . $data['keywords'] . "%");
            $condition['Goods.g_id'] = array('like', $data['keywords'] . "%");
            $condition['_logic'] = "OR";
        }

        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        //exit();


        list($list, $page, $count) = $GoodsViewModel->getList($condition, 10);
        $this->assign('list', $list);
        $this->assign('page', $page);
        $this->assign('count', $count);
        /*echo "<pre>";
        print_r($list[0]);
        echo "</pre>";
        exit();*/
        $this->display();
    }

    public function list_save()
    {
        $data = $this->_Post();
        $list = array();
        foreach ($data as $k => $v) {
            if ($k == 'weight') {
                foreach ($v as $i => $j) {
                    $list[$i] = array('g_id' => $i, 'g_weight' => $j);
                }
            }
            if ($k == 'g_unit') {
                foreach ($v as $i => $j) {
                    $list[$i]['g_unit'] = $j;
                }
            }
            if ($k == 'g_value') {
                foreach ($v as $i => $j) {
                    $list[$i]['g_value'] = $j;
                }
            }
        }

        $GoodsInfoModel = new GoodsInfoModel();
        $sql = '';
        $jumpUrl = $_SERVER['HTTP_REFERER'];

        $Model = new Model();
        $Model->startTrans();
        foreach ($list as $v) {
            try {
                $GoodsInfoModel->save($v);
            } catch (Exception $e) {
                $Model->rollback();
                $this->ajaxReturn(show_data(array('url' => $jumpUrl), '更新失败', 0, 'arr'));
            }
        }
        $Model->commit();
        $this->ajaxReturn(show_data(array('url' => $jumpUrl), '更新成功', 1, 'arr'));
    }
}