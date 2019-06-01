<div class="control-group {if $field->getErrorFlag()} error {/if}">
							<label class="control-label" for="inputEmail">{$field->getTitle()} {if $field->getParam('is_required')}<font color="red">*</font>{/if}</label>
								<div class="controls">
									<span class="btn btn-file">
							
										<input type="file" name="{$field->name}" id="image" />
									</span>
									{if $field->getErrorFlag()} 
													{foreach from=$field->getErrorMessageList() key=key item=message}
														<span class="help-inline">{$message}</span>
														
												{/foreach}
										  {/if}
						
								</div>
							</div>