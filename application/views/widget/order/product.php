<table class="table table-border table-bordered  table-striped table-bg table-hover table-sort dataTable no-footer">
    <thead>
        <tr class="text-c">
            <th>店铺名</th>
            <th>产品名</th>
            <th>数量</th>
            <th>价格</th>
            <th>图片</th>
        </tr>
    </thead>
    <tbody>
        <?foreach ($data as $k => $v):?>
        <tr class="text-c">
            <td><?=$v['sShopName']?></td>
            <td><?=$v['gName']?></td>
            <td><?=$v['gNum']?></td>
            <td><?=$v['gPrice']?></td>
            <td><img width="100" height="100" src="<?=$v['gPicture']?>"></td>
        </tr>
            
        <?endforeach;?>
    </tbody>
</table>

