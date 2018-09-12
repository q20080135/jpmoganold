<aside class="Hui-aside">
    <input runat="server" id="divScrollValue" type="hidden" value="" />
    <div class="menu_dropdown bk_2">
        <dl id="menu-product">
    <?php foreach ($menu as $key=>$val):?>
	    	
		        <dl id="menu-product">
		            <dt><i class="Hui-iconfont"><?php echo $val['mLcon'];?></i> <?php echo $val['mName'];?><i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
		            <dd>
		                <ul>
		                	
		                    <?php foreach ($val['sub_node'] as $k=>$v):?>
		                   				<li><a _href="<?=site_url($v['mUrl'])?>" href="javascript:;"><?php echo $v['mName'];?></a></li>
                   			<?php endforeach;?>
		                </ul>
		            </dd>
    <?php endforeach;?>
        </dl>
    <!-- 
            <dl id="menu-product">
            <dt><i class="Hui-iconfont">&#xe620;</i> 产品管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a _href="<?=site_url('product/product_list')?>" href="javascript:;">产品列表</a></li>
                     <li><a _href="product-category.html" data-title="分类管理" href="javascript:void(0)">分类管理</a></li>
                    <li><a _href="product-list.html" data-title="产品管理" href="javascript:void(0)">产品管理</a></li> 
                </ul>
            </dd> 
        </dl>-->
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>