<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/openplc/templates/region--footer.html.twig */
class __TwigTemplate_59f9b649f62ff61fe7b3c5c9a1972a97 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 15
        echo "
   <div id=\"footer\" style=\"background: black;margin-top:100px;\">
       <div class=\"container\">
           <div class=\"row\" style=\"margin-top:5px;\">
                 <div class=\"col-md-4\">
                   <center>
                    <a href=\"https://fossee.in\" target=\"_blank\"><img style=\" width:150px;background: #fff;\"src=\"";
        // line 21
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 21, $this->source) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 21, $this->source)), "html", null, true);
        echo "/image/fossee-logo.png\"/><a/>
                   </center>
                 </div>
                 <div class=\"col-md-4\">
                   <center>
                        <a href=\"https://www.iitb.ac.in/\" target=\"_blank\"><img style=\"width: 80px;height: 80px;\" src=\"";
        // line 26
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 26, $this->source) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 26, $this->source)), "html", null, true);
        echo "/image/iitb-logo.png\"/><a/>
                   </center>
                 </div>
                 <div class=\"col-md-4\">
                   <center>
                        <a href=\"https://mhrd.gov.in/ict-initiatives\" target=\"_blank\"><img style=\"width: 150px;background: #fff;height: 55px;\"src=\"";
        // line 31
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 31, $this->source) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 31, $this->source)), "html", null, true);
        echo "/image/NMEICT.png\"/></a>
                   </center>
                 </div>
               </div>
               <div class=\"row\">
                  <p><center><p style=\"color:#fff\">This work is licensed under a Creative Commons Attribution-ShareAlike 4.0 International License</p></center></p>
                  <center><a href='https://creativecommons.org/licenses/by-sa/4.0/'/><img src=\"";
        // line 37
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($this->sandbox->ensureToStringAllowed(($context["base_path"] ?? null), 37, $this->source) . $this->sandbox->ensureToStringAllowed(($context["directory"] ?? null), 37, $this->source)), "html", null, true);
        echo "/image/footer_license.png\" ></a></center>
               </div>
       </div>
   </div>
";
    }

    public function getTemplateName()
    {
        return "themes/openplc/templates/region--footer.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  72 => 37,  63 => 31,  55 => 26,  47 => 21,  39 => 15,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/openplc/templates/region--footer.html.twig", "/var/www/html/SBHS-D10/themes/openplc/templates/region--footer.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array("escape" => 21);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape'],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
