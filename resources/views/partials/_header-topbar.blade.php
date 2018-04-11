<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
	<div class="m-stack__item m-topbar__nav-wrapper">
		<ul class="m-topbar__nav m-nav m-nav--inline">
			<!--[html-partial:include:{"file":"partials\/_topbar-search-dropdown.html"}]/-->
			@include("partials._topbar-search-dropdown")
			<!--[html-partial:include:{"file":"partials\/_topbar-notifications.html"}]/-->
			@include("partials._topbar-notifications")
			<!--[html-partial:include:{"file":"partials\/_topbar-quick-actions.html"}]/-->
			@include("partials._topbar-quick-actions")
			<!--[html-partial:include:{"file":"partials\/_topbar-user-profile.html"}]/-->
			@include("partials._topbar-user-profile")
			<li id="m_quick_sidebar_toggle" class="m-nav__item">
				<a href="#" class="m-nav__link m-dropdown__toggle">
					<span class="m-nav__link-icon">
						<i class="flaticon-grid-menu"></i>
					</span>
				</a>
			</li>
		</ul>
	</div>
</div>
<!-- END: Topbar -->
