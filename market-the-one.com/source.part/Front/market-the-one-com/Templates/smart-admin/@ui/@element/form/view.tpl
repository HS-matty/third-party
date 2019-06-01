		


				
											<fieldset>
												
									{foreach from=$ui_element->getFields() value=field}
										{if !$field->view->is_allowed == 1}
												<section>
													<label class="label"><strong>{$field->getTitle()}:</strong></label>
													<label class="input">
																	{$field->getValueString()}
													</label>
													{if $field->note}
														<div class="note">
															{$field->note->getValue()}
														</div>
													{/if}
												</section>
										{/if}										
									{/foreach}
											
											</fieldset>
