/* タイトル */
QTags.addButton( 'h2', 'h2', '<h2>', '</h2>', '', 'h2', 1 );
QTags.addButton( 'h3', 'h3', '<h3>', '</h3>', '', 'h3', 1 );
QTags.addButton( 'h4', 'h4', '<h4>', '</h4>', '', 'h4', 1 );

/* テキスト */
QTags.addButton( 'text_p', 'テキスト', '<p>', '</p>', '', 'p', 1 );
QTags.addButton( 'text_b', '太字', '<b>', '</b>', '', 'b', 1 );
QTags.addButton( 'text_em', '太字（色付き）', '<em>', '</em>', '', 'em', 1 );
QTags.addButton( 'text_strong', '太字（ラインマーカー）', '<strong>', '</strong>', '', 'strong', 1 );

/* リンク */
QTags.addButton( 'link_blsnk', '外部リンク', '<a href="#" target="_blank">', '</a>', '', '外部リンク', 1 );
QTags.addButton( 'link_pdf', 'PDFリンク', '<a href="#" target="_blank" class="link-pdf">', '</a>', '', 'PDFリンク', 1 );

/* リスト */
QTags.addButton( 'list_nomal', '通常リスト', '<ul>', '</ul>', '', '通常リスト', 1 );
QTags.addButton( 'list_note', '注釈リスト（※）', '<ul class="note-list">', '</ul>', '', '注釈リスト', 1 );
QTags.addButton( 'list_annotation', '注釈リスト（＊）', '<ul class="annotation-list">', '</ul>', '', '注釈リスト', 1 );
QTags.addButton( 'list_num', '番号付きリスト', '<ol>', '</ol>', '', '番号付きリスト', 1 );
QTags.addButton( 'list_note-num', '番号付き注釈リスト', '<ol class="note-num-list">', '</ol>', '', '番号付き注釈リスト', 1 );

/* メディア */
QTags.addButton( 'media_img', '画像', '<figure>', '<figcaption></figcaption></figure>', '', '画像', 1 );
QTags.addButton( 'media_video', '動画', '<div class="video">', '</div>', '', '動画', 1 );

/* 引用 */
QTags.addButton( 'quote_block', '引用', '<blockquote cite="http://">', '<cite>出典：ここに引用元を入れる</cite></blockquote>', '', '引用', 1 );
QTags.addButton( 'quote_facility', '紹介', '<div class="facility">', '</div>', '', '紹介', 1 );

/* 埋め込み */
QTags.addButton( 'embedded_map', 'Googleマップ', '<div class="googlemap">', '</div>', '', 'Googleマップ', 1 );
QTags.addButton( 'embedded_tweet', 'tweet', '<div class="tweet">', '</div>', '', 'tweet', 1 );
