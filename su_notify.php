<?php
/* 
Plugin Name: Stanford Email Notification
Description: This plugin sends email to all registered users every time a new post is published.
Version: 1.0 
Author: Marco Wise
Author URI: http://www.stanford.edu/dept/its/

Copyright (c) 2011, Board of Trustees, Leland Stanford Jr. University.
All rights reserved.
 
Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:
 
Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
    
Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
    
Neither the name of Stanford University nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.
 
THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

*/

function notify_members ($post_ID) {
  global $wpdb;
  $title   = 'New Post on ' . get_bloginfo('name');
  $from    = 'From: ' . get_bloginfo('admin_email') . "\r\n";
  $headers = $from;
  $body    = $title . "\n\n";
  $body   .= 'A new post has been published: ' . get_the_title($post_ID) . "\n\n"; 
  $body   .= get_permalink($post_ID);
  $users = $wpdb->get_results( "SELECT user_email FROM $wpdb->users;" );
  foreach ($users as $user) {
    wp_mail($user->user_email,$title,$body,$headers);
  }
}

// call this only for the first time it's published
add_action('draft_to_publish', 'notify_members');
?>
