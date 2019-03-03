#!/usr/bin/env sh

chcon -v -t httpd_sys_rw_content_t dnd_website_config/*.ini
