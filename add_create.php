<?php include_once "top.php";
include_once "add_left.php";?>
<div class="addbar">
    <ul>
    <h2>生成</h2>
    <li><label>静态页：</label><label style="width:820px;">
        <span class="ablk"><a href="html_index.php">首页</a> - index</span>
        <span class="ablk"><a href="html_sets.php">牌库首页</a> - sets</span>
        <span class="ablk"><a>版本列表页</a> - clist [<?php echo count($db->ig2_select('sets',1))?>]</span>
        <span class="ablk"><a>百科首页</a> - dictionary</span>
        <span class="ablk"><a href="html_aboutus.php">关于我们</a> - aboutus</span>
        <span class="ablk"><a href="html_faq.php">FAQ</a> - faq</span>
        <span class="ablk"><a href="html_volunteer.php">志愿者计划</a> - volunteer</span>
        <span class="ablk"><a href="html_contact.php">联系我</a> - content</span>
        <span class="ablk"><a href="html_public.php">公益</a> - public</span>
        </label>
    </li>
    <li><label>T2套牌清理：</label><a href="ra_add.php?t2clear=1">转移到环境赛</a></li>
    <li><label>更新禁牌表</label><a href="ra_add.php?updateBanned=1">更新</a></li>
    <li><label>模拟轮抓：</label>
        <input name="set_id" value="" id="sets" placeholder="版本ID" />
        <input name="pack" value="" id="pack" placeholder="包数量" />
        <select name="lang" id="lang">
            <option value="en">EN</option>
            <option value="">CN</option>
        </select>
        <input type="button" value="生成" onClick="location.href='add_wheeldraw.php?id='+$('#sets').val()+'&pack='+$('#pack').val()+'&lang='+$('#lang').val()" />
    </li>
    <li><label>生成优惠券：</label>
        <form action="ra_add.php" method="get">
        <select name="vname">
            <option value="1">牌套</option>
            <option value="2">牌垫</option>
            <option value="3">马克杯</option>
            <option value="4">250g铜版纸不覆膜</option>
            <option value="5">250g白卡纸不覆膜</option>
            <option value="6">250g铜版纸覆膜</option>
            <option value="7">250g白卡纸覆膜</option>
        </select>
        <input name="vprice" value="" placeholder="优惠价格" />
        <input type="submit" name="create_tb_voucher" value="生成" />
        </form>
    </li>
    <script>
    function getVoucherContent(vcode){
	    $.ajax({
			url:"ra_ajax.php?getVoucherContent="+vcode,
			dataType:"text",
			success: function(responeText){
			    $('#v_content').html(responeText);
			}
		});
	}
    </script>
    <li><form action="ra_add.php" method="post">
        <label>核销优惠券：</label><input name="vcoded" value="" placeholder="优惠码" onBlur="getVoucherContent(this.value)" />
        <input name="tbname" value="" placeholder="淘宝昵称" />
        <input type="submit" name="writeoff_tb_voucher" value="核销" />
        <span id="v_content"></span>
        </form>
    </li>
    <li><label>生成全牌面：</label>
    	<input id="fullFolder" value="" placeholder="输入文件夹名" />
    	<input type="button" name="getFull" value="生成" onClick="location.href='temp_fullSizeImageMaker.php?f='+$('#fullFolder').val();" />
    </li>
    <li><label>删临时套牌：</label><a href="ra_add.php?delTempDeck=1">删吧</a></li>
    </ul>
</div>

<?php include_once "down.php";?>