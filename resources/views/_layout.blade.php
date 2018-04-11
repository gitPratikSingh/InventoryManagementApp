<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	<!--[html-partial:include:{"file":"partials\/_header-base.html"}]/-->
	@include("partials._header-base")
				<!-- begin::Body -->
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
		<!--[html-partial:include:{"file":"partials\/_aside-left.html"}]/-->
		@include("partials._aside-left")
		<div class="m-grid__item m-grid__item--fluid m-wrapper">
			<!--[html-partial:include:{"file":"partials\/_subheader-default.html"}]/-->
			@include("partials._subheader-default")
			<div class="m-content">
				m-content
				
				<div class="m-alert m-alert--icon m-alert--air m-alert--square alert alert-dismissible m--margin-bottom-30" role="alert">
					<div class="m-alert__icon">
						<i class="flaticon-exclamation m--font-warning"></i>
					</div>
					<div class="m-alert__text">
						<h3 class="m-subheader__title m-subheader__title--separator"> {!! ucfirst(@$pagename) !!}
                    		<small>List of all the equipments in the inventory.</small>
                		</h3>
					</div>
				</div>
				
				<div class="m-portlet m-portlet--mobile">

					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<h3 class="m-portlet__head-text">Ajax Datatable</h3>
						</div>

						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--open" data-dropdown-toggle="hover" aria-expanded="true">
										<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
											<i class="la la-ellipsis-h m--font-brand"></i>
										</a>
										<div class="m-dropdown__wrapper">
											<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 21.5px;"></span>
											<div class="m-dropdown__inner">
												<div class="m-dropdown__body">
													<div class="m-dropdown__content">
														<ul class="m-nav">
															<li class="m-nav__section m-nav__section--first">
																<span class="m-nav__section-text">
																	Quick Actions
																</span>
															</li>
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-share"></i>
																	<span class="m-nav__link-text">
																		Create Post
																	</span>
																</a>
															</li>
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-chat-1"></i>
																	<span class="m-nav__link-text">
																		Send Messages
																	</span>
																</a>
															</li>
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-multimedia-2"></i>
																	<span class="m-nav__link-text">
																		Upload File
																	</span>
																</a>
															</li>
															<li class="m-nav__section">
																<span class="m-nav__section-text">
																	Useful Links
																</span>
															</li>
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-info"></i>
																	<span class="m-nav__link-text">
																		FAQ
																	</span>
																</a>
															</li>
															<li class="m-nav__item">
																<a href="" class="m-nav__link">
																	<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																	<span class="m-nav__link-text">
																		Support
																	</span>
																</a>
															</li>
															<li class="m-nav__separator m-nav__separator--fit m--hide"></li>
															<li class="m-nav__item m--hide">
																<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
																	Submit
																</a>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>

					</div>

					<div class="m-portlet__body">
						<div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
							<div class="row align-items-center">
								<div class="col-xl-10 order-2 order-xl-1">
									<div class="form-group m-form__group row align-items-center">
											<div class="col-sm-4">
												<div class="m-input-icon m-input-icon--left">
													<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch">
													<span class="m-input-icon__icon m-input-icon__icon--left">
															<span><i class="la la-search"></i></span>
													</span>
												</div>
											</div>
											
											<div class="col-sm-2"></div>

											<div class="col-sm-3 m--align-right">
												<div class="col-xl-2 order-1 order-xl-2 m--align-right">
													<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="edit" hidden>
														<span>
															<i class="la la-edit"></i>
															<span>
																Edit
															</span>
														</span>
													</a>
												</div>
											</div>

											<div class="col-sm-3 m--align-right">
												<div class="col-xl-2 order-1 order-xl-2 m--align-right">
													<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" id="delete" hidden>
														<span>
															<i class="la la-trash"></i>
															<span>
																Delete
															</span>
														</span>
													</a>
												</div>
											</div>

										</div>
									</div>

								<div class="col-xl-2 order-1 order-xl-2 m--align-right">
									<a href="#" class="btn btn-primary m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air" data-toggle="modal" data-target="#m_switch_modal">
										<span>
											<i class="fa flaticon-squares"></i>
											<span>
												Column Preferences
											</span>
										</span>
									</a>
									<div class="m-separator m-separator--dashed d-xl-none"></div>
								</div>

							</div>
						</div>
						<div class="m_datatable" id="scrolling_both">
							
							
							
						
						</div>
						
						<!--begin::Modal-->
						<div class="modal fade" id="m_switch_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="">
											Column Preferences
										</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true" class="la la-remove"></span>
										</button>
									</div>
									<form class="m-form m-form--fit m-form--label-align-right">
										<div class="modal-body">
											<div class="m-demo__preview">
														<!--begin::Form-->
														<form class="m-form">
															<div class="m-form__group form-group row">
																<label class="col-2 col-form-label">
																	Make & Model
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="make_name">
																			<span></span>
																		</label>
																	</span>
																</div>
																
																<label class="col-2 col-form-label">
																	Name
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="name">
																			<span></span>
																		</label>
																	</span>
																</div>

																<label class="col-2 col-form-label">
																	Purchase Date
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="purchase_date">
																			<span></span>
																		</label>
																	</span>
																</div>
															</div>

															<div class="m-form__group form-group row">
																<label class="col-2 col-form-label">
																	Serial Number
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="serial_number">
																			<span></span>
																		</label>
																	</span>
																</div>
																
																<label class="col-2 col-form-label">
																	Barcode
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="barcode">
																			<span></span>
																		</label>
																	</span>
																</div>

																<label class="col-2 col-form-label">
																	Owner
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="owner">
																			<span></span>
																		</label>
																	</span>
																</div>
															</div>

															<div class="m-form__group form-group row">
																<label class="col-2 col-form-label">
																	Unit Name
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="unit_name">
																			<span></span>
																		</label>
																	</span>
																</div>
																
																<label class="col-2 col-form-label">
																	Status
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="status">
																			<span></span>
																		</label>
																	</span>
																</div>

																<label class="col-2 col-form-label">
																	Type
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="type">
																			<span></span>
																		</label>
																	</span>
																</div>
															</div>

															<div class="m-form__group form-group row">
																<label class="col-2 col-form-label">
																	Actions
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="actions">
																			<span></span>
																		</label>
																	</span>
																</div>
																
																<label class="col-2 col-form-label">
																	Updated
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="updated_at">
																			<span></span>
																		</label>
																	</span>
																</div>

																<label class="col-2 col-form-label">
																	Created
																</label>
																<div class="col-2">
																	<span class="m-switch m-switch--icon">
																		<label>
																			<input type="checkbox" checked="checked" id="created_at">
																			<span></span>
																		</label>
																	</span>
																</div>
															</div>

														</form>
														<!--end::Form-->
													</div>
										</div>

										<div class="modal-footer">
											<button type="button" class="btn btn-brand m-btn" data-dismiss="modal" id="modal_close">
												Cancel
											</button>
											<button type="button" class="btn btn-secondary m-btn" id="modal_submit">
												Submit
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!--end::Modal-->
					
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
	<!-- end:: Body -->				
<!--[html-partial:include:{"file":"partials\/_footer-default.html"}]/-->
@include("partials._footer-default")

</div>
<!-- end:: Page -->    		        
<!--[html-partial:include:{"file":"partials\/_layout-quick-sidebar.html"}]/-->
@include("partials._layout-quick-sidebar")
<!--[html-partial:include:{"file":"partials\/_layout-scroll-top.html"}]/-->
@include("partials._layout-scroll-top")
<!--[html-partial:include:{"file":"partials\/_layout-tooltips.html"}]/-->
@include("partials._layout-tooltips")
