<?php

namespace App\Http\Controllers;

use App\Models\{HeroSlide, Service, ProcessStep, PortfolioItem, TechCategory, Testimonial, Faq, Stat, Logo, WebTemplate, PricingPlan};

class HomeController extends Controller
{
    public function index()
    {
        $heroSlides   = HeroSlide::where('is_active', true)->orderBy('sort')->get();
        $designs      = WebTemplate::where('is_active', true)->orderBy('sort')->take(9)->get();
        $designCategories = $designs->pluck('category')->unique()->values();
        $domainPlans  = PricingPlan::where('type', 'domain')->where('is_active', true)->orderBy('sort')->get();
        $packagePlans = PricingPlan::where('type', 'package')->where('is_active', true)->orderBy('sort')->get();
        $services     = Service::where('is_active', true)->orderBy('sort')->get();
        $steps        = ProcessStep::where('is_active', true)->orderBy('sort')->get();
        $portfolio    = PortfolioItem::where('is_active', true)->orderBy('sort')->take(6)->get();
        $tech         = TechCategory::where('is_active', true)->orderBy('sort')->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort')->get();
        $faqs         = Faq::where('is_active', true)->orderBy('sort')->get();
        $stats        = Stat::where('is_active', true)->orderBy('sort')->get();
        $logos        = Logo::where('is_active', true)->orderBy('sort')->get();

        return view('pages.home', compact(
            'heroSlides', 'designs', 'designCategories', 'domainPlans', 'packagePlans', 'services', 'steps', 'portfolio', 'tech', 'testimonials', 'faqs', 'stats', 'logos'
        ));
    }
}
