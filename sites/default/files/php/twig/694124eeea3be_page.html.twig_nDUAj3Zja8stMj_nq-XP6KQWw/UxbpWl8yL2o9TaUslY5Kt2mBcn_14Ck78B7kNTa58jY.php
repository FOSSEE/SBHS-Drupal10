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

/* themes/openplc/templates/page.html.twig */
class __TwigTemplate_09be688ad1cb081c249c82fa5fddd127 extends Template
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
        // line 46
        $context["has_sidebar_first"] =  !twig_test_empty(twig_trim_filter(twig_striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 46), 46, $this->source)))));
        // line 47
        $context["has_sidebar_second"] =  !twig_test_empty(twig_trim_filter(twig_striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 47), 47, $this->source)))));
        // line 48
        echo "<div class=\"container-fluid\" style=\"background: #e5f5cb;\">
    ";
        // line 49
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "banner", [], "any", false, false, true, 49), 49, $this->source), "html", null, true);
        echo "
    <header role=\"banner\">
      ";
        // line 51
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 51), 51, $this->source), "html", null, true);
        echo "
    </header>

    ";
        // line 54
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 54), 54, $this->source), "html", null, true);
        echo "
    ";
        // line 55
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 55), 55, $this->source), "html", null, true);
        echo "
    ";
        // line 56
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 56), 56, $this->source), "html", null, true);
        echo "
    ";
        // line 57
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "openplc_corousal", [], "any", false, false, true, 57), 57, $this->source), "html", null, true);
        echo "

    ";
        // line 59
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 59), 59, $this->source), "html", null, true);
        echo "
    ";
        // line 60
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 60), 60, $this->source), "html", null, true);
        echo "
    <main role=\"main\">
        <a id=\"main-content\" tabindex=\"-1\">
        </a>
            <div class=\"container-fluid\">
                <div class=\"row\">
                    ";
        // line 66
        if ((($context["has_sidebar_first"] ?? null) && ($context["has_sidebar_second"] ?? null))) {
            // line 67
            echo "                        ";
            if (($context["has_sidebar_first"] ?? null)) {
                // line 68
                echo "                                <div class=\"col-sm-3\"  role=\"complementary\">
                                    ";
                // line 69
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 69), 69, $this->source), "html", null, true);
                echo "
                                </div>
                        ";
            }
            // line 72
            echo "                            <div class=\"col-sm-6\">
                                ";
            // line 73
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 73), 73, $this->source), "html", null, true);
            echo "
                            </div>";
            // line 75
            echo "                        ";
            if (($context["has_sidebar_second"] ?? null)) {
                // line 76
                echo "                                <div class=\"col-sm-3\" style=\"float: right;\"  role=\"complementary\">
                                    ";
                // line 77
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 77), 77, $this->source), "html", null, true);
                echo "
                                </div>
                        ";
            }
            // line 80
            echo "                    ";
        } elseif ((($context["has_sidebar_first"] ?? null) || ($context["has_sidebar_second"] ?? null))) {
            // line 81
            echo "                        ";
            if (($context["has_sidebar_first"] ?? null)) {
                // line 82
                echo "                                <div class=\"col-sm-3\"  role=\"complementary\">
                                    ";
                // line 83
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 83), 83, $this->source), "html", null, true);
                echo "
                                </div>
                            <div class=\"col-sm-9\">
                                ";
                // line 86
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 86), 86, $this->source), "html", null, true);
                echo "
                            </div>";
                // line 88
                echo "                        ";
            } elseif (($context["has_sidebar_second"] ?? null)) {
                // line 89
                echo "                            <div class=\"col-sm-9\">
                                ";
                // line 90
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 90), 90, $this->source), "html", null, true);
                echo "
                            </div>";
                // line 92
                echo "                            <div class=\"col-sm-3\" style=\"float: right;\"  role=\"complementary\">
                                ";
                // line 93
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 93), 93, $this->source), "html", null, true);
                echo "
                            </div>
                        ";
            } else {
                // line 96
                echo "                            <div class=\"col-xl-12 \">
                                ";
                // line 97
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 97), 97, $this->source), "html", null, true);
                echo "
                            </div>";
                // line 99
                echo "                        ";
            }
            // line 100
            echo "                    ";
        } else {
            // line 101
            echo "                        <div class=\"col-xl-12 \">
                            ";
            // line 102
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 102), 102, $this->source), "html", null, true);
            echo "
                        </div>";
            // line 104
            echo "                    ";
        }
        // line 105
        echo "                </div>
            </div>
    </main>
    ";
        // line 109
        echo "    ";
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 109), 109, $this->source), "html", null, true);
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "themes/openplc/templates/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  186 => 109,  181 => 105,  178 => 104,  174 => 102,  171 => 101,  168 => 100,  165 => 99,  161 => 97,  158 => 96,  152 => 93,  149 => 92,  145 => 90,  142 => 89,  139 => 88,  135 => 86,  129 => 83,  126 => 82,  123 => 81,  120 => 80,  114 => 77,  111 => 76,  108 => 75,  104 => 73,  101 => 72,  95 => 69,  92 => 68,  89 => 67,  87 => 66,  78 => 60,  74 => 59,  69 => 57,  65 => 56,  61 => 55,  57 => 54,  51 => 51,  46 => 49,  43 => 48,  41 => 47,  39 => 46,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/openplc/templates/page.html.twig", "/var/www/html/SBHS-D10/themes/openplc/templates/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 46, "if" => 66);
        static $filters = array("trim" => 46, "striptags" => 46, "render" => 46, "escape" => 49);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['trim', 'striptags', 'render', 'escape'],
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
