<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Category;
use App\Models\Question;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 

class FooterController extends Controller{
	
    public function privacyNotice(){
        return view('footer_pages.privacy_notice');
    }
	
	public function termCondition(){
        return view('footer_pages.term_condition');
    }
	
	public function accessibilityDeclaration(){
        return view('footer_pages.accessibility_declaration');
    }
	
	public function disclaimer(){
        return view('footer_pages.disclaimer');
    }
	
	public function securityPolicy(){
        return view('footer_pages.security_policy');
    }
 
}