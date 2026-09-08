<?php

namespace App\Http\Middleware;

use Closure;

class WidgetShortcodeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if(!method_exists($response, 'content')):
            return $response;
        endif;

        $content = str_replace('[awa_widget1]', '
            <style>
            .awasam-promo10 {
                background-color: #F0F6FD;
                color: #367FD3;
                padding: 10px;
                margin: 20px;
            }
            </style>

            <main>
            <div class="awasam-promo10">
            <h2>Why would you need help with your Assignment?</h2>
            <p>Do not struggle with your Assignment when we are here to help. We are aware that every student aims at getting better grades. This prompts most of them to look for help on online platforms like ours. However, different students seek help with their assignments for different reasons. We have listed some of them below.
            </p>

            <ul>
            <li>To save time</li>
            <li>Desire to achieve excellent grades</li>
            <li>Fear of failure</li>
            <li>When you want to work with professionals</li>
            <li>For high-quality and well-researched assignments</li>
            <li>When the assignment is beyond your capability</li>
            <li>When you do not have time to work on the assignment</li>
            </ul>

            <h3>Need Our Services?</h3>
            <p>
            For the rates we charge, our services are the finest you can get. At&nbsp;<a href="https://'.domain_name().'/"><strong>'.domain_name().'</strong></a>, we do way more than just coaching students to become better academic writers. We also encourage and motivate every ambitious student so they can stay the course throughout their program. We have the competence, experience, processes, people, and systems to help you turn your dreams into reality. Head over to the order form right now. Submit your instructions. We&nbsp;<strong>GUARANTEE</strong>&nbsp;that you’ll get a model paper that oozes brilliance.</p>
            <a href='. url('order') .' class="button">Get Professional Assignment Help Now</a>
            </div>
            </main>    
            ', $response->content());

        
        $response->setContent($content);
        return $response;


    }
}
