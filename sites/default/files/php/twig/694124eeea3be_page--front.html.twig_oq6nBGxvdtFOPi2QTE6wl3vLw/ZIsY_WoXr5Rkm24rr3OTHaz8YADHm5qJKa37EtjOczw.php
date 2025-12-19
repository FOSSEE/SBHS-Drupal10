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

/* themes/openplc/templates/page--front.html.twig */
class __TwigTemplate_3feaa5cfb4c64173bbc6779ca4789c68 extends Template
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
        // line 1
        echo " ";
        $context["has_sidebar_first"] =  !twig_test_empty(twig_trim_filter(twig_striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 1), 1, $this->source)))));
        // line 2
        $context["has_sidebar_second"] =  !twig_test_empty(twig_trim_filter(twig_striptags($this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 2), 2, $this->source)))));
        // line 3
        echo "

 <div class=\"container-fluid\" style=\"background: #e5f5cb;\">
    ";
        // line 6
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "banner", [], "any", false, false, true, 6), 6, $this->source), "html", null, true);
        echo "
        <p> &nbsp;</p>

    <header role=\"banner\">
      ";
        // line 10
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 10), 10, $this->source), "html", null, true);
        echo "
    </header>
    <br />

    ";
        // line 14
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 14), 14, $this->source), "html", null, true);
        echo "
    ";
        // line 15
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "secondary_menu", [], "any", false, false, true, 15), 15, $this->source), "html", null, true);
        echo "

    ";
        // line 17
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "openplc_corousal", [], "any", false, false, true, 17), 17, $this->source), "html", null, true);
        echo "

    ";
        // line 19
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 19), 19, $this->source), "html", null, true);
        echo "
    ";
        // line 20
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 20), 20, $this->source), "html", null, true);
        echo "
    ";
        // line 21
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 21), 21, $this->source), "html", null, true);
        echo "
    <main role=\"main\">
        <a id=\"main-content\" tabindex=\"-1\">
        </a>
            <div class=\"container-fluid\">
                <div class=\"row\">
                    ";
        // line 27
        if ((($context["has_sidebar_first"] ?? null) && ($context["has_sidebar_second"] ?? null))) {
            // line 28
            echo "                        ";
            if (($context["has_sidebar_first"] ?? null)) {
                // line 29
                echo "                                <div class=\"col-sm-3\"  role=\"complementary\">
                                    ";
                // line 30
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 30), 30, $this->source), "html", null, true);
                echo "
                                </div>
                        ";
            }
            // line 33
            echo "                            <div class=\"col-sm-6\">
                                ";
            // line 34
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 34), 34, $this->source), "html", null, true);
            echo "
                            </div>";
            // line 36
            echo "                        ";
            if (($context["has_sidebar_second"] ?? null)) {
                // line 37
                echo "                                <div class=\"col-sm-3\" style=\"float: right;\"  role=\"complementary\">
                                    ";
                // line 38
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 38), 38, $this->source), "html", null, true);
                echo "
                                </div>
                        ";
            }
            // line 41
            echo "                    ";
        } elseif ((($context["has_sidebar_first"] ?? null) || ($context["has_sidebar_second"] ?? null))) {
            // line 42
            echo "                        ";
            if (($context["has_sidebar_first"] ?? null)) {
                // line 43
                echo "                                <div class=\"col-sm-3\"  role=\"complementary\">
                                    ";
                // line 44
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 44), 44, $this->source), "html", null, true);
                echo "
                                </div>
                            <div class=\"col-sm-9\">
                                ";
                // line 47
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 47), 47, $this->source), "html", null, true);
                echo "
                            </div>";
                // line 49
                echo "                        ";
            } elseif (($context["has_sidebar_second"] ?? null)) {
                // line 50
                echo "                            <div class=\"col-sm-9\">
                                ";
                // line 51
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 51), 51, $this->source), "html", null, true);
                echo "
                            </div>";
                // line 53
                echo "                            <div class=\"col-sm-3\" style=\"float: right;\"  role=\"complementary\">
                                ";
                // line 54
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 54), 54, $this->source), "html", null, true);
                echo "
                            </div>
                        ";
            } else {
                // line 57
                echo "                            <div class=\"col-xl-12 \">
                                ";
                // line 58
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 58), 58, $this->source), "html", null, true);
                echo "
                            </div>";
                // line 60
                echo "                        ";
            }
            // line 61
            echo "                    ";
        } else {
            // line 62
            echo "                        <div class=\"col-xl-12 \">
                            ";
            // line 63
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 63), 63, $this->source), "html", null, true);
            echo "
                        </div>";
            // line 65
            echo "                    ";
        }
        // line 66
        echo "                </div>
            </div>
    </main>

    ";
        // line 70
        echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 70), 70, $this->source), "html", null, true);
        echo "
  </div>";
    }

    public function getTemplateName()
    {
        return "themes/openplc/templates/page--front.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  194 => 70,  188 => 66,  185 => 65,  181 => 63,  178 => 62,  175 => 61,  172 => 60,  168 => 58,  165 => 57,  159 => 54,  156 => 53,  152 => 51,  149 => 50,  146 => 49,  142 => 47,  136 => 44,  133 => 43,  130 => 42,  127 => 41,  121 => 38,  118 => 37,  115 => 36,  111 => 34,  108 => 33,  102 => 30,  99 => 29,  96 => 28,  94 => 27,  85 => 21,  81 => 20,  77 => 19,  72 => 17,  67 => 15,  63 => 14,  56 => 10,  49 => 6,  44 => 3,  42 => 2,  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/openplc/templates/page--front.html.twig", "/var/www/html/SBHS-D10/themes/openplc/templates/page--front.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 1, "if" => 27);
        static $filters = array("trim" => 1, "striptags" => 1, "render" => 1, "escape" => 6);
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
