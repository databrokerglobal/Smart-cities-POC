<?php if($site_themes){ ?>
body{
    font-family: {{ FONT_FAMILY[$site_themes->body_font_family] }} !important;
}    
.fixed_bg {
    background-color: {{ $site_themes->header_color }};
}
.app-reveal-section-notify h1 {
    color: {{ $site_themes->header_color }};
}
.text-primary {
    color: {{ $site_themes->header_color }} !important;
}
#main_menu .navbar-nav li a.active, #main_menu .navbar-nav li:hover a{
    color: {{ $site_themes->header_color }};
}
.primary-btn, .customize-btn{
    background-color: {{ $site_themes->primary_button_color }};
}
.primary-btn:hover, .customize-btn:hover{
    background-color: {{ $site_themes->primary_button_color }};
}
.secondary-btn, .button.blue-outline{
    border: 2px solid {{ $site_themes->header_color }};
    border-radius: 25px;
    color: {{ $site_themes->header_color }};
    font-family: {{ FONT_FAMILY[$site_themes->body_font_family] }};
}
.fixed_bg .dropdown-menu a.dropdown-item:hover {
    background-color: {{ $site_themes->header_color }} !important;
}
.blog-header h1, .cat-header h1 {
  
    color: {{ $site_themes->header_color }};
}
.secondary-btn:hover, .button.blue-outline:hover {
    border: 2px solid {{ $site_themes->primary_button_color }};
    color: {{ $site_themes->primary_button_color }};
}
.footer-section {
    
    background-color: {{ $site_themes->footer_color }};
   
}
.btn-primary {
   
    background-color: {{ $site_themes->primary_button_color }};
    border-color: {{ $site_themes->primary_button_color }};
    
}
.btn-primary:hover {
    
    background-color: {{ $site_themes->primary_button_color }};
    border-color: {{ $site_themes->primary_button_color }};
}
.btn-focus {
    color: #fff;
    background-color:  {{ $site_themes->secondary_button_color }};
    border-color:  {{ $site_themes->secondary_button_color }};
}
.btn-focus:hover {
   
    background-color: {{ $site_themes->secondary_button_color }};
    border-color: {{ $site_themes->secondary_button_color }};
}
.btn-outline-focus.m-btn--air, .btn-focus.m-btn--air, .m-btn--gradient-from-focus.m-btn--air {
    -webkit-box-shadow: 0px 5px 3px 2px {{ $site_themes->secondary_button_color }} !important;
    box-shadow: 0px 5px 3px 2px {{ $site_themes->secondary_button_color }} !important;
}
.btn-focus:not(:disabled):not(.disabled):active, .btn-focus:not(:disabled):not(.disabled).active, .show > .btn-focus.dropdown-toggle {
    color: #fff;
    background-color: {{ $site_themes->secondary_button_color }};
    border-color: {{ $site_themes->secondary_button_color }};
}
.btn-outline-focus.m-btn--air.focus, .btn-outline-focus.m-btn--air:focus, .btn-outline-focus.m-btn--air:hover, .btn-focus.m-btn--air.focus, .btn-focus.m-btn--air:focus, .btn-focus.m-btn--air:hover, .m-btn--gradient-from-focus.m-btn--air.focus, .m-btn--gradient-from-focus.m-btn--air:focus, .m-btn--gradient-from-focus.m-btn--air:hover {
    -webkit-box-shadow: 0px 5px 3px 2px  {{ $site_themes->secondary_button_color }} !important;
    box-shadow: 0px 5px 3px 2px  {{ $site_themes->secondary_button_color }} !important;
}

<?php } ?>