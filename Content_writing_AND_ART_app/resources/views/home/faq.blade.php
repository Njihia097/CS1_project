<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    
    <!-- Css Styles -->
    <link rel="stylesheet" href="{{ asset('home/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/font-awesome.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/themify-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/elegant-icons.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/owl.carousel.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/nice-select.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/jquery-ui.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/slicknav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('home/css/style.css') }}" type="text/css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        #faqSearch {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }
        .faq-section {
            margin-bottom: 20px;
        }
        .faq-section h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        .faq-item {
            margin-bottom: 15px;
        }
        .faq-item h3 {
            font-size: 18px;
            color: #343a40;
        }
        .faq-item p {
            font-size: 16px;
            color: #6c757d;
            margin-left: 20px;
        }
        #noResults {
            text-align: center;
            color: #dc3545;
            font-weight: bold;
            margin-top: 20px;
            display: none; /* Initially hidden */
        }
    </style>
</head>
<body>
    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="{{ url('/view_userpage') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Faq</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>Frequently Asked Questions</h1>
        <input type="text" id="faqSearch" placeholder="Search FAQs..." onkeyup="searchFAQs()">
        <div id="noResults">No results found</div>
        <div class="faq-section">
            <h2>Account</h2>
            <div class="faq-item">
                <h3>How do I create an account?</h3>
                <p>Go to the sign-up page, fill in your details, and click "Create Account." You will receive a confirmation email. Click the link in the email to activate your account.</p>
            </div>
            <div class="faq-item">
                <h3>How do I reset my password?</h3>
                <p>Click on "Forgot Password" on the login page, enter your email address, and you will receive instructions on how to reset your password.</p>
            </div>
        </div>
        <div class="faq-section">
            <h2>Writing</h2>
            <div class="faq-item">
                <h3>How do I start a new writing project?</h3>
                <p>Go to your dashboard, click on "New Project," and fill in the required information to start your writing project.</p>
            </div>
            <div class="faq-item">
                <h3>Can I collaborate with other writers?</h3>
                <p>Yes, you can invite other writers to collaborate on your projects by going to the project settings and adding their email addresses.</p>
            </div>
        </div>
        <!-- Add more sections and items as needed -->
    </div>

    <script>
        function searchFAQs() {
            var input, filter, faqSections, faqItems, i, txtValue, noResults;
            input = document.getElementById('faqSearch');
            filter = input.value.toLowerCase();
            faqSections = document.getElementsByClassName('faq-section');
            noResults = document.getElementById('noResults');
            let noMatch = true;

            for (i = 0; i < faqSections.length; i++) {
                let faqItems = faqSections[i].getElementsByClassName('faq-item');
                let sectionMatch = false;
                
                for (let j = 0; j < faqItems.length; j++) {
                    let question = faqItems[j].getElementsByTagName('h3')[0];
                    let answer = faqItems[j].getElementsByTagName('p')[0];
                    txtValue = question.textContent || question.innerText;
                    
                    if (txtValue.toLowerCase().indexOf(filter) > -1 || answer.textContent.toLowerCase().indexOf(filter) > -1) {
                        faqItems[j].style.display = "";
                        sectionMatch = true;
                        noMatch = false;
                    } else {
                        faqItems[j].style.display = "none";
                    }
                }

                if (sectionMatch) {
                    faqSections[i].style.display = "";
                } else {
                    faqSections[i].style.display = "none";
                }
            }

            noResults.style.display = noMatch ? "" : "none";
        }
    </script>

<script src="{{ asset('home/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('home/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('home/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('home/js/jquery.nice-select.min.js') }}"></script>
<script src="{{ asset('home/js/jquery.zoom.min.js') }}"></script>
<script src="{{ asset('home/js/jquery.dd.min.js') }}"></script>
<script src="{{ asset('home/js/jquery.slicknav.js') }}"></script>
<script src="{{ asset('home/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('home/js/main.js') }}"></script>
</body>
</html>
