<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Delta Academy</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f0f2f5;
        }
        
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #3c4085 0%, #9abf6f 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .logo-container {
            margin: 20px auto;
        }
        
        .logo-cell {
            background-color: #fff;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            text-align: center;
        }
        
        .logo-img {
            max-width: 80%;
            height: auto;
        }
        
        .content {
            padding: 30px;
            background-color: #ffffff;
        }
        
        .feature-box {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            margin: 20px 0;
            border: 1px solid #eaeaea;
            width: 100%;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #3c4085 0%, #9abf6f 100%);
            color: #ffffff;
            padding: 15px 35px;
            text-decoration: none;
            border-radius: 30px;
            margin: 20px 0;
            font-weight: bold;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .footer {
            background: #f5f5f5;
            padding: 30px 20px;
            text-align: center;
            font-size: 14px;
            color: #777777;
            border-top: 1px solid #eaeaea;
        }
        
        .social-icons {
            margin: 20px 0;
        }
        
        .social-icons a {
            display: inline-block;
            margin: 0 8px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            transform: scale(1.2);
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
        }
        
        .footer-links {
            margin: 15px 0;
        }
        
        .footer-links a {
            color: #3c4085;
            text-decoration: none;
            margin: 0 10px;
            font-weight: 600;
        }
        
        .footer-links a:hover {
            text-decoration: underline;
        }
        
        .copyright {
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }
        
        @media screen and (max-width: 480px) {
            .logo-container {
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
            
            .logo-cell {
                width: 100px;
                height: 100px;
            }
            
            .cta-button {
                display: block;
                text-align: center;
                margin: 25px auto;
            }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animated {
            animation: fadeIn 0.8s ease-out;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <!-- Header Section -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="header animated">
            <tr>
                <td align="center">
                    <table width="90%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td align="center">
                                <table class="logo-container">
                                    <tr>
                                        <td class="logo-cell">
                                            <img src="{{ asset('img/delta-logo.png') }}" alt="Delta Logo" class="logo-img">
                                        </td>
                                        <td class="logo-cell">
                                            <img src="{{ asset('img/delta-academy.png') }}" alt="Delta Academy" class="logo-img">
                                        </td>
                                    </tr>
                                </table>
                                <h1 style="margin: 10px 0; font-size: 28px;">Welcome to Delta Academy</h1>
                                <p style="margin: 5px 0 20px; font-size: 18px;">A journey of learning and development</p>
                                
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <!-- Content Section -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="content">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                                <table class="feature-box">
                                    <tr>
                                        <td>
                                            <h3>{{ $user['user_detail']->fav_lang == 'english' ?  Dear : 'مرحباً ' }} {{ $user['user_detail']->first_name }},</h3>

                                            <p> {{ $user['user_detail']->fav_lang == 'english' ? 'Ready to start a new journey of learning ?' : 'هل أنت مستعد لبدء رحلة جديدة من التعلم؟' }}</p>

                                            <p>
                                                {{ $user['user_detail']->fav_lang == 'english' ? 'A new pathway is assigned to you under the name of ' . $data['assignment_title'] : 'تمت إضافة لك مسار تدريبي جديد تحت عنوان' . $data['assignment_title']  }}.</p>
                                            
                                            <h4 style="margin: 20px 0 10px;">
                                                {{ $user['user_detail']->fav_lang == 'english' ? 'Kindly follow the link to start your course' : '' }}
                                            </h4>
                                            
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td align="center">
                                                        <a href="{{ $data['site_url'] }}" target="_blank" class="cta-button">Click Here</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <!-- Footer Section -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="footer">
            <tr>
                <td align="center">
                    <div class="social-icons">
                        <a href="https://www.facebook.com/people/Delta-Academy/61560504450217/?mibextid=ZbWKwL" target="_blank">
                            <img src="https://cdn-icons-png.flaticon.com/256/124/124010.png" alt="Facebook" class="social-icon">
                        </a>
                        <a href="https://x.com/deltaacademy24?s=21&t=YWMNDGoZwaMUSI1gfhATyw" target="_blank">
                            <img src="https://w7.pngwing.com/pngs/748/680/png-transparent-twitter-x-logo.png" alt="Twitter" class="social-icon">
                        </a>
                        <a href="https://www.youtube.com/@DeltaAcademy.medlab" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/09/YouTube_full-color_icon_%282017%29.svg/1280px-YouTube_full-color_icon_%282017%29.svg.png" alt="YouTube" class="social-icon">
                        </a>
                        <a href="https://www.linkedin.com/company/delta-academy-medlab/" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/81/LinkedIn_icon.svg/2048px-LinkedIn_icon.svg.png" alt="LinkedIn" class="social-icon">
                        </a>
                        <a href="https://www.instagram.com/deltaacademy24/?igsh=bnNuOWhzY2Y3aWtv#" target="_blank">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/1024px-Instagram_icon.png" alt="Instagram" class="social-icon">
                        </a>
                    </div>
                    
                    <div class="footer-links">
                        <a href="mailto:Training@delta-medlab.com">Training@delta-medlab.com</a> | 
                        <a href="https://academy.delta-medlab.com/" target="_blank">academy.delta-medlab.com</a>
                    </div>
                    
                    <div class="copyright">
                        &copy; 2024 Delta Academy. All rights reserved.<br>
                        This email was sent to mukul@example.com
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
