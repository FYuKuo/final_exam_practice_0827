<fieldset>
    <legend>目前位置 : 首頁 > 最新文章區</legend>
    <table >
        <tr class="ct ">
            <td>標題</td>
            <td>內容</td>
            <td></td>
        </tr>
        <?php
        $num = $News->math('COUNT','id',['sh'=>1]);
        $limit = 5;
        $pages = ceil($num/$limit);
        $page = ($_GET['page'])??1;
        if($page <= 0 || $page > $pages){
            $page = 1;
        }
        $start = ($page-1)*$limit;
        $limitSql = " Limit $start,$limit";
        $rows = $News->all(['sh'=>1],$limitSql);
        foreach ($rows as $key => $row) {
        ?>
        <tr>
            <td class="clo w-20 myClickTitle"><?=$row['title']?></td>
            <td class="w-60">
                <span>
                    <?=mb_substr($row['text'],0,20)?>...
                </span>
                <span style="display: none;">
                    <?=$row['text']?>
                </span>
            </td>
            <td>
                <?php
                if(isset($_SESSION['user'])){
                    if(empty($Log->find(['user'=>$_SESSION['user'],'que'=>$row['id']]))){
                ?>
                <span class="goodBtn" onclick="add_good(<?=$row['id']?>,<?=($row['good']+1)?>,1)">讚</span>
                <?php
                    }else{
                ?>
                <span class="goodBtn" onclick="add_good(<?=$row['id']?>,<?=($row['good']-1)?>,0)">收回讚</span>
                <?php
                    }
                }
                ?>
            </td>
        </tr>
        <?php
        }
        ?>
    </table>
    <div class="page">
        <?php
        if($page > 1){
        ?>
        <a href="?do=news&page=<?=$page-1?>">&lt;</a>
        <?php
        }
        for ($i=1; $i <= $pages; $i++) { 
        ?>
        <a href="?do=news&page=<?=$i?>" class="<?=($page == $i)?'nowPage':''?>"><?=$i?></a>
        <?php
        }
        if($page < $pages){
        ?>
        <a href="?do=news&page=<?=$page+1?>">&gt;</a>
        <?php
        }
        ?>
    </div>
</fieldset>

<script>
    function add_good(id,good,type){
        $.post('./api/add_good.php',{id,good,type},()=>{
            location.reload();
        })
    }

    $('.myClickTitle').on('click',function(){
        $(this).next().children().toggle();
    })
</script>