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

/* database/data_dictionary/index.twig */
class __TwigTemplate_e8b63aa77af93eb1bcf3cd1007bc26cccbdae775b33a89eee0064c72001712b2 extends \Twig\Template
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
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<h1>";
        echo twig_escape_filter($this->env, ($context["database"] ?? null), "html", null, true);
        echo "</h1>
";
        // line 2
        if ( !twig_test_empty(($context["comment"] ?? null))) {
            // line 3
            echo "  <p>";
            echo _gettext("Database comment:");
            echo " <em>";
            echo twig_escape_filter($this->env, ($context["comment"] ?? null), "html", null, true);
            echo "</em></p>
";
        }
        // line 5
        echo "
<div>
  ";
        // line 7
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["tables"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["table"]) {
            // line 8
            echo "    <div>
      <h2>";
            // line 9
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["table"], "name", [], "any", false, false, false, 9), "html", null, true);
            echo "</h2>
      ";
            // line 10
            if ( !twig_test_empty(twig_get_attribute($this->env, $this->source, $context["table"], "comment", [], "any", false, false, false, 10))) {
                // line 11
                echo "        <p>";
                echo _gettext("Table comments:");
                echo " <em>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["table"], "comment", [], "any", false, false, false, 11), "html", null, true);
                echo "</em></p>
      ";
            }
            // line 13
            echo "
      <table class=\"print\">
        <tr>
          <th>";
            // line 16
            echo _gettext("Column");
            echo "</th>
          <th>";
            // line 17
            echo _gettext("Type");
            echo "</th>
          <th>";
            // line 18
            echo _gettext("Null");
            echo "</th>
          <th>";
            // line 19
            echo _gettext("Default");
            echo "</th>
          ";
            // line 20
            if (twig_get_attribute($this->env, $this->source, $context["table"], "has_relation", [], "any", false, false, false, 20)) {
                // line 21
                echo "            <th>";
                echo _gettext("Links to");
                echo "</th>
          ";
            }
            // line 23
            echo "          <th>";
            echo _gettext("Comments");
            echo "</th>
          ";
            // line 24
            if (twig_get_attribute($this->env, $this->source, $context["table"], "has_mime", [], "any", false, false, false, 24)) {
                // line 25
                echo "            <th>";
                echo _gettext("Media (MIME) type");
                echo "</th>
          ";
            }
            // line 27
            echo "        </tr>
        ";
            // line 28
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["table"], "columns", [], "any", false, false, false, 28));
            foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                // line 29
                echo "          <tr>
            <td class=\"nowrap\">
              ";
                // line 31
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["column"], "name", [], "any", false, false, false, 31), "html", null, true);
                echo "
              ";
                // line 32
                if (twig_get_attribute($this->env, $this->source, $context["column"], "has_primary_key", [], "any", false, false, false, 32)) {
                    // line 33
                    echo "                <em>(";
                    echo _gettext("Primary");
                    echo ")</em>
              ";
                }
                // line 35
                echo "            </td>
            <td lang=\"en\" dir=\"ltr\"";
                // line 36
                echo (((("set" != twig_get_attribute($this->env, $this->source, $context["column"], "type", [], "any", false, false, false, 36)) && ("enum" != twig_get_attribute($this->env, $this->source, $context["column"], "type", [], "any", false, false, false, 36)))) ? (" class=\"nowrap\"") : (""));
                echo ">
              ";
                // line 37
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["column"], "print_type", [], "any", false, false, false, 37), "html", null, true);
                echo "
            </td>
            <td>";
                // line 39
                echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["column"], "is_nullable", [], "any", false, false, false, 39)) ? (_gettext("Yes")) : (_gettext("No"))), "html", null, true);
                echo "</td>
            <td class=\"nowrap\">
              ";
                // line 41
                if (((null === twig_get_attribute($this->env, $this->source, $context["column"], "default", [], "any", false, false, false, 41)) && twig_get_attribute($this->env, $this->source, $context["column"], "is_nullable", [], "any", false, false, false, 41))) {
                    // line 42
                    echo "                <em>NULL</em>
              ";
                } else {
                    // line 44
                    echo "                ";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["column"], "default", [], "any", false, false, false, 44), "html", null, true);
                    echo "
              ";
                }
                // line 46
                echo "            </td>
            ";
                // line 47
                if (twig_get_attribute($this->env, $this->source, $context["table"], "has_relation", [], "any", false, false, false, 47)) {
                    // line 48
                    echo "              <td>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["column"], "relation", [], "any", false, false, false, 48), "html", null, true);
                    echo "</td>
            ";
                }
                // line 50
                echo "            <td>";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["column"], "comment", [], "any", false, false, false, 50), "html", null, true);
                echo "</td>
            ";
                // line 51
                if (twig_get_attribute($this->env, $this->source, $context["table"], "has_mime", [], "any", false, false, false, 51)) {
                    // line 52
                    echo "              <td>";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["column"], "mime", [], "any", false, false, false, 52), "html", null, true);
                    echo "</td>
            ";
                }
                // line 54
                echo "          </tr>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 56
            echo "      </table>

      ";
            // line 58
            echo twig_get_attribute($this->env, $this->source, $context["table"], "indexes_table", [], "any", false, false, false, 58);
            echo "
    </div>
  ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['table'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 61
        echo "</div>

<p class=\"print_ignore\">
  <input type=\"button\" class=\"btn btn-secondary button\" id=\"print\" value=\"";
        // line 64
        echo _gettext("Print");
        echo "\">
</p>
";
    }

    public function getTemplateName()
    {
        return "database/data_dictionary/index.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  220 => 64,  215 => 61,  206 => 58,  202 => 56,  195 => 54,  189 => 52,  187 => 51,  182 => 50,  176 => 48,  174 => 47,  171 => 46,  165 => 44,  161 => 42,  159 => 41,  154 => 39,  149 => 37,  145 => 36,  142 => 35,  136 => 33,  134 => 32,  130 => 31,  126 => 29,  122 => 28,  119 => 27,  113 => 25,  111 => 24,  106 => 23,  100 => 21,  98 => 20,  94 => 19,  90 => 18,  86 => 17,  82 => 16,  77 => 13,  69 => 11,  67 => 10,  63 => 9,  60 => 8,  56 => 7,  52 => 5,  44 => 3,  42 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "database/data_dictionary/index.twig", "/var/www/html/roslesinforg/web/phpmyadmin/templates/database/data_dictionary/index.twig");
    }
}
