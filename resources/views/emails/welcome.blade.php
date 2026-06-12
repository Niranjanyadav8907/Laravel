<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Welcome to Quiz App</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9; padding:30px 0;">
<tr>
<td align="center">

<table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

<!-- Header -->
<tr>
<td style="background:linear-gradient(90deg,#ff758c,#ff7eb3); padding:30px; text-align:center; color:#ffffff;">
<h2 style="margin:0; font-size:26px;">Welcome to Quiz App 🎉</h2>
<p style="margin:8px 0 0; font-size:14px;">Start learning and testing your knowledge</p>
</td>
</tr>

<!-- Body -->
<tr>
<td style="padding:30px;">
<h3 style="margin-top:0; color:#333;">Hello, {{ $user->name }} 👋</h3>

<p style="color:#555; line-height:1.6;">
Thank you for registering with our Quiz App. You can now explore quizzes,
challenge yourself, and improve your knowledge.
</p>

<p style="color:#555; line-height:1.6;">
We’re excited to have you as part of our community.
</p>

<br>

<!-- Button -->
<table cellpadding="0" cellspacing="0">
<tr>
<td align="center">
<a href="{{ url('/') }}"
style="
background:linear-gradient(90deg,#ff758c,#ff7eb3);
color:#ffffff;
padding:14px 28px;
text-decoration:none;
border-radius:50px;
display:inline-block;
font-weight:bold;
font-size:14px;
">
Start Quiz
</a>
</td>
</tr>
</table>

</td>
</tr>

<!-- Footer -->
<tr>
<td style="background:#f8f9fb; padding:20px; text-align:center; font-size:13px; color:#888;">
© {{ date('Y') }} Quiz App. All rights reserved.
</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>