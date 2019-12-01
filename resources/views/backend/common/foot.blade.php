<div class="modal fade bs-example-modal-sm sl-dialog-delete" tabindex="-1" role="dialog" aria-labelledby="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<p>确认要删除吗？</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn sl-button-primary" onclick="slDoDelete();">删除</button>
				<button type="button" class="btn sl-button-danger" data-dismiss="modal">取消</button>
				<input type="hidden" name="sl_id" value=""/>
				<input type="hidden" name="sl_type" value=""/>
			</div>
		</div>
	</div>
</div>

<div class="modal fade sl-dialog-add" tabindex="-1" role="dialog" aria-labelledby="addDialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="addDialog"></h4>
			</div>
			<div class="modal-body">
				<iframe src="/admin/home/welcome" width="100%" frameborder="0" scrolling="auto" onload="slIframe(this)"></iframe>
			</div>
			<input type="hidden" name="sl_id" value=""/>
			<input type="hidden" name="sl_type" value=""/>
			<input type="hidden" name="sl_parent" value=""/>
		</div>
	</div>
</div>

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/packages/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/common.js"></script>