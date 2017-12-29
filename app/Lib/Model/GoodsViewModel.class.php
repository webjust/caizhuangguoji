<?php

class GoodsViewModel extends ViewModel
{
    public $viewFields = array(
        'Goods' => array('g_id', 'gb_id', 'new_weight', 'hot_weight', 'g_on_sale', 'g_status', 'g_new', 'g_hot', 'g_guess', 'g_high', 'g_create_time', '_type' => 'LEFT'),
        'GoodsInfo' => array('g_name', 'g_picture', 'g_declare_type', 'g_value', 'g_price', 'g_market_price', 'g_purchase_price_cn', 'g_tax', 'g_weight', 'g_unit', 'g_bar_code', '_on' => 'GoodsInfo.g_id=Goods.g_id'),
        'GoodsProducts' => array('g_id', 'pdt_id', 'pdt_sale_price', 'pdt_cost_price', 'pdt_market_price', 'pdt_weight', 'pdt_total_stock', 'pdt_stock', 'pdt_freeze_stock', 'pdt_purchasing_nums', 'pdt_bar_code', '_on' => 'GoodsProducts.g_id=Goods.g_id'),
        'GoodsBrand' => array('gb_name', '_on' => 'GoodsBrand.gb_id=Goods.gb_id'),
        //'RelatedGoodsCategory' => array('_on' => 'RelatedGoodsCategory.g_id=Goods.g_id'),
        //'GoodsCategory' => array('gc_name', 'gc_declare_type','_on' => 'GoodsCategory.gc_id=RelatedGoodsCategory.gc_id'),
    );

    public function getList($condition = array(), $size = 30, $order = array('Goods.g_id' => 'desc'))
    {
        $count = $this->where($condition)->count();
        import('ORG.Util.Page');    // 导入分页类
        $page = new Page($count, $size);
        $list = $this->where($condition)->order($order)->limit($page->firstRow . ',' . $page->listRows)->group('Goods.g_id')->select();
        //echo $this->getLastSql();
        //exit();
        return array($list, $page->show(), $count);
    }
}