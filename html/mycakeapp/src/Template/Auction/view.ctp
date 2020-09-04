<h2>「<?= $biditem->name ?>」の情報</h2>
<table class="vertical-table">
	<tr>
		<th class="small" scope="row">出品者</th>
		<td><?= $biditem->has('user') ? $biditem->user->username : '' ?></td>
	</tr>
	<tr>
		<th scope="row">商品名</th>
		<td><?= h($biditem->name) ?></td>
	</tr>
	<tr>
		<th scope="row">商品詳細</th>
		<td><?= h($biditem->detail) ?></td>
	</tr>
	<tr>
		<th scope="row">商品画像</th>
		<!-- 画像表示 -->
		<td><?= $this->Html->image($biditem->image_path, array('height' => 200, 'width' => 200)) ?></td>
	</tr>
	<tr>
		<th scope="row">商品ID</th>
		<td><?= $this->Number->format($biditem->id) ?></td>
	</tr>
	<tr>
		<th scope="row">終了時間</th>
		<td><?= h($biditem->endtime) ?></td>
	</tr>
	<tr>
		<th scope="row">投稿時間</th>
		<td><?= h($biditem->created) ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('終了した？') ?></th>
		<td><?= $biditem->finished ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
		<th scope="row">オークション終了まで</th>
		<?php
		$endtime = new DateTime($biditem->endtime);
		$format_endtime = $endtime->format("Y/m/d/ H:i:s");
		$nowtime = new DateTime('now');
		$format_nowtime = $nowtime->format("Y/m/d/ H:i:s")
		?>
		<script>
			function dateCounter() {
				var timer = setInterval(function() {
					//現在の日時取得
					var nowDate = new Date();
					//カウントダウンしたい日を設定
					var anyDate = new Date("<?= $format_endtime ?>");
					//日数を計算
					var daysBetween = Math.floor((anyDate - nowDate) / (1000 * 60 * 60 * 24));
					var ms = (anyDate - nowDate);
					console.log(ms);
					if (ms >= 0) {
						//時間を取得
						var h = Math.floor(ms / 3600000);
						var _h = h % 24;
						//分を取得
						var m = Math.floor((ms - h * 3600000) / 60000);
						//秒を取得
						var s = Math.round((ms - h * 3600000 - m * 60000) / 1000);
						//HTML上に出力
						document.getElementById("countOutput").innerHTML = daysBetween + "日" + _h + "時間" + m + "分" + s + "秒";
						nowDate++;
						if ((h == 0) && (m == 0) && (s == 0)) {
							clearInterval(timer);
							document.getElementById("countOutput").innerHTML = "終了しました";
						}
					} else {
						document.getElementById("countOutput").innerHTML = "終了しました";
					}
				}, 1000);
			}
			dateCounter();
		</script>
		<td>
			<div id="countOutput"></div>
		</td>
	</tr>
</table>
<div class="related">
	<h4> <?= __('落札情報') ?> </h4> <?php if (!empty($biditem->bidinfo)) : ?> <table cellpadding="0" cellspacing="0">
			<tr>
				<th scope="col"> 落札者 </th>
				<th scope="col"> 落札金額 </th>
				<th scope="col"> 落札日時 </th>
			</tr>
			<tr>
				<td> <?= h($biditem->bidinfo->user->username) ?> < /td> < td> <?= h($biditem->bidinfo->price) ?>円 </td>
				<td> <?= h($biditem->endtime) ?> </td>
			</tr>
		</table> <?php else : ?> <p> <?= '※落札情報は、ありません。' ?> </p> <?php endif; ?>
</div>
<div class="related">
	<h4> <?= __('入札情報') ?> </h4> <?php if (!$biditem->finished) : ?> <h6>
			<a href="<?= $this->Url->build(['action' => 'bid', $biditem->id]) ?>"> 《入札する！》 </a> </h6>
		<?php if (!empty($bidrequests)) : ?> <table cellpadding="0" cellspacing="0">

				<head>
					<tr>
						<th scope="col"> 入札者 </th>
						<th scope="col"> 金額 </th>
						<th scope="col"> 入札日時 </th>
					</tr>
					</thead>
					<tbody>
						<?php foreach ($bidrequests as $bidrequest) : ?> < tr>
								<td> <?= h($bidrequest->user->username) ?> </td>
								<td> <?= h($bidrequest->price) ?>円 </td>
								<td> <?= $bidrequest->created ?> </td>
								</tr> <?php endforeach; ?> </tbody>
			</table> <?php else : ?> <p> <?= '※入札は、まだありません。' ?> </p> <?php endif; ?> <?php else : ?> <p> <?= '※入札は、終了しました。' ?> </p> <?php endif; ?>
</div>
