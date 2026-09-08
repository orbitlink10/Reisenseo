<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $sname}}</title>
</head>
<body>
<h1 style="text-align: center; padding: 20px 10px; background-color: #23527c; color: #FFF;">
{{ $sname}}
</h1>
<p>
{!! $description !!}
</p>



<div style="text-align: center; padding: 20px 10px; background-color: #e9e9e9; color: #000000;">
<p>Access your account via:</p>

 <a href="https://{{ domain_name() }}" style="background-color: #4CAF50;
border: none;
color: white;
padding: 10px 20px;
text-align: center;
text-decoration: none;
display: inline-block;
font-size: 16px;
margin: 4px 2px;
cursor: pointer;
border-radius: 10px;">
My Account </a>
<p>Send us an email to {{ get_option('admin_email') }} or call us {{ get_option(site_id().'_admin_phone') }}</p>
<p>Kind regards</p>
<p>{{ get_option(site_id().'_site_name') }} support</p>

</div>
<br>
</body>
</html>


