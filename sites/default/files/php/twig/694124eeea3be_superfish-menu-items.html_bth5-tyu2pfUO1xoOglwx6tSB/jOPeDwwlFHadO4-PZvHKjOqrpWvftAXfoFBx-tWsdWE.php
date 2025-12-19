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

/* modules/contrib/superfish/templates/superfish-menu-items.html.twig */
class __TwigTemplate_b593bc2cd173859df92ea43fe7a8f843 extends Template
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
        // line 21
        echo "
";
        // line 22
        $context["classes"] = [];
        // line 23
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["menu_items"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 24
            echo "
  ";
            // line 25
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 25))) {
                // line 26
                echo "    ";
                $context["item_class"] = ($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "item_class", [], "any", false, false, true, 26), 26, $this->source) . " menuparent");
                // line 27
                echo "    ";
                if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_column", [], "any", false, false, true, 27)) {
                    // line 28
                    echo "      ";
                    $context["item_class"] = ($this->sandbox->ensureToStringAllowed(($context["item_class"] ?? null), 28, $this->source) . " sf-multicolumn-column");
                    // line 29
                    echo "    ";
                }
                // line 30
                echo "  ";
            }
            // line 31
            echo "
  <li";
            // line 32
            echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "attributes", [], "any", false, false, true, 32), 32, $this->source), "html", null, true);
            echo " role=\"none\">
    ";
            // line 33
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_column", [], "any", false, false, true, 33)) {
                // line 34
                echo "    <div class=\"sf-multicolumn-column\">
    ";
            }
            // line 36
            echo "
    ";
            // line 37
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 37))) {
                // line 38
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_array_merge($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "link_menuparent", [], "any", false, false, true, 38), 38, $this->source), ["#attributes" => ["role" => "menuitem", "aria-haspopup" => "true", "aria-expanded" => "false"]]), "html", null, true);
                echo "
    ";
            } else {
                // line 40
                echo "      ";
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, twig_array_merge($this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "link", [], "any", false, false, true, 40), 40, $this->source), ["#attributes" => ["role" => "menuitem"]]), "html", null, true);
                echo "
    ";
            }
            // line 42
            echo "
    ";
            // line 43
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_wrapper", [], "any", false, false, true, 43)) {
                // line 44
                echo "      <ul class=\"sf-multicolumn\" role=\"menu\">
      <li class=\"sf-multicolumn-wrapper ";
                // line 45
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "item_class", [], "any", false, false, true, 45), 45, $this->source), "html", null, true);
                echo "\" role=\"none\">
    ";
            }
            // line 47
            echo "
    ";
            // line 48
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 48))) {
                // line 49
                echo "
      ";
                // line 50
                if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_content", [], "any", false, false, true, 50)) {
                    // line 51
                    echo "        <ol role=\"menu\">
      ";
                } else {
                    // line 53
                    echo "        <ul role=\"menu\">
      ";
                }
                // line 55
                echo "
      ";
                // line 56
                echo $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(twig_get_attribute($this->env, $this->source, $context["item"], "children", [], "any", false, false, true, 56), 56, $this->source), "html", null, true);
                echo "

      ";
                // line 58
                if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_content", [], "any", false, false, true, 58)) {
                    // line 59
                    echo "        </ol>
      ";
                } else {
                    // line 61
                    echo "        </ul>
      ";
                }
                // line 63
                echo "
    ";
            }
            // line 65
            echo "
    ";
            // line 66
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_wrapper", [], "any", false, false, true, 66)) {
                // line 67
                echo "      </li>
      </ul>
    ";
            }
            // line 70
            echo "
    ";
            // line 71
            if (twig_get_attribute($this->env, $this->source, $context["item"], "multicolumn_column", [], "any", false, false, true, 71)) {
                // line 72
                echo "    </div>
    ";
            }
            // line 74
            echo "  </li>

";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
    }

    public function getTemplateName()
    {
        return "modules/contrib/superfish/templates/superfish-menu-items.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  170 => 74,  166 => 72,  164 => 71,  161 => 70,  156 => 67,  154 => 66,  151 => 65,  147 => 63,  143 => 61,  139 => 59,  137 => 58,  132 => 56,  129 => 55,  125 => 53,  121 => 51,  119 => 50,  116 => 49,  114 => 48,  111 => 47,  106 => 45,  103 => 44,  101 => 43,  98 => 42,  92 => 40,  86 => 38,  84 => 37,  81 => 36,  77 => 34,  75 => 33,  71 => 32,  68 => 31,  65 => 30,  62 => 29,  59 => 28,  56 => 27,  53 => 26,  51 => 25,  48 => 24,  44 => 23,  42 => 22,  39 => 21,);
    }

    public function getSourceContext()
    {
        return new Source("", "modules/contrib/superfish/templates/superfish-menu-items.html.twig", "/var/www/html/SBHS-D10/modules/contrib/superfish/templates/superfish-menu-items.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 22, "for" => 23, "if" => 25);
        static $filters = array("escape" => 32, "merge" => 38);
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['set', 'for', 'if'],
                ['escape', 'merge'],
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
