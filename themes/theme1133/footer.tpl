{if !isset($content_only) || !$content_only}
					</div><!-- #center_column -->
					{if isset($right_column_size) && !empty($right_column_size)}
						<div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
					{/if}
					</div><!-- .row -->
				</div><!-- #columns -->
			</div><!-- .columns-container -->
			{if isset($HOOK_HOME) && $HOOK_HOME|trim}
				<div id="parallax-home">
					 <div class="container">
						<div class="row">{$HOOK_HOME}</div>
					</div>
				</div>
			{/if}
			{if isset($HOOK_FOOTER)}
				<!-- Footer -->
				<div class="footer-container">
					<footer id="footer"  class="container">
					</footer>
				</div><!-- #footer -->
			{/if}
			<div class="footer-logo">
				<!-- <a  rel="nofollow"><img src="" alt="logo"></a> -->
				<div class="row">	&#169; Powered by AutoSol Limited. All Rights Reserved. </div>

			</div>
		</div><!-- #page -->
{/if}

{include file="$tpl_dir./global.tpl"}
	</body>
</html>
