<?php /* #?ini charset="iso-8859-1"?

[news_full_view_1]
Source=node/view/full.tpl
MatchFile=welcome.tpl
Subdir=templates
Match[node]=2

[news_full_view_2]
Source=node/view/full.tpl
MatchFile=news_full_view.tpl
Subdir=templates
Match[node]=72

[line_folder]
Source=node/view/line.tpl
MatchFile=line/folder.tpl
Subdir=templates
Match[class_identifier]=folder

[embed_folder_list]
Source=content/view/embed.tpl
MatchFile=embed/folder_list.tpl
Subdir=templates
Match[class_identifier]=folder
Match[classification]=list

[embed_folder_subtree]
Source=content/view/embed.tpl
MatchFile=embed/folder_subtree.tpl
Subdir=templates
Match[class_identifier]=folder
Match[classification]=subtreelist

[embed_folder_contentlist]
Source=content/view/embed.tpl
MatchFile=embed/folder_contentlist.tpl
Subdir=templates
Match[class_identifier]=folder

[edit_user]
Source=content/edit.tpl
MatchFile=edit/user.tpl
Subdir=templates
Match[class_identifier]=user

[article_line]
Source=node/view/line.tpl
MatchFile=line/article.tpl
Subdir=templates
Match[class_identifier]=article

[article_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/article.tpl
Subdir=templates
Match[class_identifier]=article

[article_embed]
Source=content/view/embed.tpl
MatchFile=embed/article.tpl
Subdir=templates
Match[class_identifier]=article

[class_image]
Source=content/datatype/view/ezobjectrelation.tpl
MatchFile=datatype/ezobjectrelation/image.tpl
Subdir=templates
Match[class_identifier]=article

[line_comment]
Source=node/view/line.tpl
MatchFile=line/comment.tpl
Subdir=templates
Match[class_identifier]=comment

[edit_comment]
Source=content/edit.tpl
MatchFile=edit/comment.tpl
Subdir=templates
Match[class_identifier]=comment

[file_line]
Source=node/view/line.tpl
MatchFile=line/file.tpl
Subdir=templates
Match[class_identifier]=file

[edit_file]
Source=content/edit.tpl
MatchFile=edit/file.tpl
Subdir=templates
Match[class_identifier]=file

[embed_file]
Source=content/view/embed.tpl
MatchFile=embed/file.tpl
Subdir=templates
Match[class_identifier]=file

[file_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/file.tpl
Subdir=templates
Match[class_identifier]=file

[file_binaryfile]
Source=content/datatype/view/ezbinaryfile.tpl
MatchFile=datatype/ezbinaryfile.tpl
Subdir=templates

[listitem_link]
Source=node/view/listitem.tpl
MatchFile=listitem/link.tpl
Subdir=templates
Match[class_identifier]=link

[line_link]
Source=node/view/line.tpl
MatchFile=line/link.tpl
Subdir=templates
Match[class_identifier]=link

[image_line]
Source=node/view/line.tpl
MatchFile=line/image.tpl
Subdir=templates
Match[class_identifier]=image

[image_galleryline]
Source=node/view/galleryline.tpl
MatchFile=galleryline/image.tpl
Subdir=templates
Match[class_identifier]=image

[image_galleryslide]
Source=node/view/galleryslide.tpl
MatchFile=galleryslide/image.tpl
Subdir=templates
Match[class_identifier]=image

[image_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/image.tpl
Subdir=templates
Match[class_identifier]=image

[image_embed]
Source=content/view/embed.tpl
MatchFile=embed/image.tpl
Subdir=templates
Match[class_identifier]=image

[text_linked_image]
Source=content/view/text_linked.tpl
MatchFile=textlinked/image.tpl
Subdir=templates
Match[class]=5

[flash_line]
Source=node/view/line.tpl
MatchFile=line/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[embed_flash]
Source=content/view/embed.tpl
MatchFile=embed/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[quicktime_line]
Source=node/view/line.tpl
MatchFile=line/quicktime.tpl
Subdir=templates
Match[class_identifier]=quicktime

[embed_quicktime]
Source=content/view/embed.tpl
MatchFile=embed/quicktime.tpl
Subdir=templates
Match[class_identifier]=quicktime

[windows_media_line]
Source=node/view/line.tpl
MatchFile=line/windows_media.tpl
Subdir=templates
Match[class_identifier]=windows_media

[embed_windows_media]
Source=content/view/embed.tpl
MatchFile=embed/windows_media.tpl
Subdir=templates
Match[class_identifier]=windows_media

[real_video_line]
Source=node/view/line.tpl
MatchFile=line/real_video.tpl
Subdir=templates
Match[class_identifier]=real_video

[embed_real_video]
Source=content/view/embed.tpl
MatchFile=embed/real_video.tpl
Subdir=templates
Match[class_identifier]=real_video

[forum_line]
Source=node/view/line.tpl
MatchFile=line/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[forum_embed]
Source=content/view/embed.tpl
MatchFile=embed/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[forum_topic_edit]
Source=content/edit.tpl
MatchFile=edit/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[forum_topic_line]
Source=node/view/line.tpl
MatchFile=line/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[forum_topic_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[forum_reply_line]
Source=node/view/line.tpl
MatchFile=line/forum_reply.tpl
Subdir=templates
Match[class_identifier]=forum_reply

[forum_reply_edit]
Source=content/edit.tpl
MatchFile=edit/forum_reply.tpl
Subdir=templates
Match[class_identifier]=forum_reply

[weblog_line]
Source=node/view/line.tpl
MatchFile=line/weblog.tpl
Subdir=templates
Match[class_identifier]=weblog

[weblog_edit]
Source=content/edit.tpl
MatchFile=edit/weblog.tpl
Subdir=templates
Match[class_identifier]=weblog

[product_line]
Source=node/view/line.tpl
MatchFile=line/product.tpl
Subdir=templates
Match[class_identifier]=product

[product_embed]
Source=content/view/embed.tpl
MatchFile=embed/product.tpl
Subdir=templates
Match[class_identifier]=product

[product_listitem]
Source=node/view/listitem.tpl
MatchFile=listitem/product.tpl
Subdir=templates
Match[class_identifier]=product

[review_line]
Source=node/view/line.tpl
MatchFile=line/review.tpl
Subdir=templates
Match[class_identifier]=review

[review_edit]
Source=content/edit.tpl
MatchFile=edit/review.tpl
Subdir=templates
Match[class_identifier]=review

[gallery_slideshow]
Source=node/view/slideshow.tpl
MatchFile=slideshow/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[gallery_line]
Source=node/view/line.tpl
MatchFile=line/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[gallery_embed]
Source=content/view/embed.tpl
MatchFile=embed/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[poll_line]
Source=node/view/line.tpl
MatchFile=line/poll.tpl
Subdir=templates
Match[class_identifier]=poll

[poll_embed]
Source=content/view/embed.tpl
MatchFile=embed/poll.tpl
Subdir=templates
Match[class_identifier]=poll

[poll_result]
Source=content/collectedinfo/poll.tpl
MatchFile=collectedinfo/poll_result.tpl
Subdir=templates

[person_line]
Source=node/view/line.tpl
MatchFile=line/person.tpl
Subdir=templates
Match[class_identifier]=person

[person_embed]
Source=content/view/embed.tpl
MatchFile=embed/person.tpl
Subdir=templates
Match[class_identifier]=person

[edit_person]
Source=content/edit.tpl
MatchFile=edit/person.tpl
Subdir=templates
Match[class_identifier]=person

[company_line]
Source=node/view/line.tpl
MatchFile=line/company.tpl
Subdir=templates
Match[class_identifier]=company

[company_embed]
Source=content/view/embed.tpl
MatchFile=embed/company.tpl
Subdir=templates
Match[class_identifier]=company

[edit_company]
Source=content/edit.tpl
MatchFile=edit/company.tpl
Subdir=templates
Match[class_identifier]=company

[feedback_form_line]
Source=node/view/line.tpl
MatchFile=line/feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[feedback_form_mail]
Source=content/collectedinfomail/form.tpl
MatchFile=collectedinfomail/feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form

[factbox]
Source=content/datatype/view/ezxmltags/factbox.tpl
MatchFile=datatype/ezxmltext/factbox.tpl
Subdir=templates

[quote]
Source=content/datatype/view/ezxmltags/quote.tpl
MatchFile=datatype/ezxmltext/quote.tpl
Subdir=templates

[price]
Source=content/datatype/view/ezprice.tpl
MatchFile=datatype/price.tpl
Subdir=templates

[matrix]
Source=content/datatype/view/ezmatrix.tpl
MatchFile=datatype/ezmatrix/view.tpl
Subdir=templates

[edit_matrix]
Source=content/datatype/edit/ezmatrix.tpl
MatchFile=datatype/ezmatrix/edit.tpl
Subdir=templates

[pdf_article_main]
Source=node/view/pdf.tpl
MatchFile=pdf/article/main.tpl
Match[class_identifier]=article
Subdir=templates

[pdf_article_title]
Source=content/datatype/pdf/ezstring.tpl
MatchFile=pdf/article/title.tpl
Match[class_identifier]=article
Match[attribute_identifier]=title
Subdir=templates

[pdf_article_author]
Source=content/datatype/pdf/ezauthor.tpl
MatchFile=pdf/article/author.tpl
Match[class_identifier]=article
Match[attribute_identifier]=author
Subdir=templates

[pdf_article_xml_headers]
Source=content/datatype/pdf/ezxmltags/header.tpl
MatchFile=pdf/article/xml_header.tpl
Match[class_identifier]=article
Subdir=templates

[pdf_article_xml_paragraph]
Source=content/datatype/pdf/ezxmltags/paragraph.tpl
MatchFile=pdf/article/xml_paragraph.tpl
Match[class_identifier]=article
Subdir=templates

[pdf_article_footer]
Source=content/pdf/footer.tpl
MatchFile=pdf/article/footer.tpl
Match[class_identifier]=article
Subdir=templates

[pdf_article_embed_image]
Source=content/pdf/embed.tpl
MatchFile=pdf/article/image.tpl
Match[class_identifier]=article
Subdir=templates


[full_view_welcome]
Source=node/view/full.tpl
MatchFile=full_view_welcome.tpl
Subdir=templates
Match[]

[about]
Source=node/view/full.tpl
MatchFile=welcome.tpl
Subdir=templates
Match[node]=66

[full_folder]
Source=node/view/full.tpl
MatchFile=full/folder.tpl
Subdir=templates
Match[class_identifier]=folder

[article_full]
Source=node/view/full.tpl
MatchFile=full/article.tpl
Subdir=templates
Match[class_identifier]=article

[full_comment]
Source=node/view/full.tpl
MatchFile=full/comment.tpl
Subdir=templates
Match[class]=13

[file_full]
Source=node/view/full.tpl
MatchFile=full/file.tpl
Subdir=templates
Match[class_identifier]=file

[full_link]
Source=node/view/full.tpl
MatchFile=full/link.tpl
Subdir=templates
Match[class_identifier]=link

[image_full]
Source=node/view/full.tpl
MatchFile=full/image.tpl
Subdir=templates
Match[class_identifier]=image

[flash_full]
Source=node/view/full.tpl
MatchFile=full/flash.tpl
Subdir=templates
Match[class_identifier]=flash

[quicktime_full]
Source=node/view/full.tpl
MatchFile=full/quicktime.tpl
Subdir=templates
Match[class_identifier]=quicktime

[windows_media_full]
Source=node/view/full.tpl
MatchFile=full/windows_media.tpl
Subdir=templates
Match[class_identifier]=windows_media

[real_video_full]
Source=node/view/full.tpl
MatchFile=full/real_video.tpl
Subdir=templates
Match[class_identifier]=real_video

[forum_full]
Source=node/view/full.tpl
MatchFile=full/forum.tpl
Subdir=templates
Match[class_identifier]=forum

[forum_topic_full]
Source=node/view/full.tpl
MatchFile=full/forum_topic.tpl
Subdir=templates
Match[class_identifier]=forum_topic

[forum_reply_full]
Source=node/view/full.tpl
MatchFile=full/forum_reply.tpl
Subdir=templates
Match[class_identifier]=forum_reply

[weblog_full]
Source=node/view/full.tpl
MatchFile=full/weblog.tpl
Subdir=templates
Match[class_identifier]=weblog

[product_full]
Source=node/view/full.tpl
MatchFile=full/product.tpl
Subdir=templates
Match[class_identifier]=product

[gallery_full]
Source=node/view/full.tpl
MatchFile=full/gallery.tpl
Subdir=templates
Match[class_identifier]=gallery

[poll_full]
Source=node/view/full.tpl
MatchFile=full/poll.tpl
Subdir=templates
Match[class_identifier]=poll

[person_full]
Source=node/view/full.tpl
MatchFile=full/person.tpl
Subdir=templates
Match[class_identifier]=person

[company_full]
Source=node/view/full.tpl
MatchFile=full/company.tpl
Subdir=templates
Match[class_identifier]=company

[feedback_form_full]
Source=node/view/full.tpl
MatchFile=full/feedback_form.tpl
Subdir=templates
Match[class_identifier]=feedback_form



*/ ?>