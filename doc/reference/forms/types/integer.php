<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">integer Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="integer-field-type">
      <span id="index-0"></span><h1>integer Field Type<a class="headerlink" href="#integer-field-type" title="Permalink to this headline">¶</a></h1>
      <p>Renders an input "number" field. Basically, this is a text field that's good
	at handling data that's in an integer form. The input <tt class="docutils literal"><span class="pre">number</span></tt> field looks
	like a text box, except that - if the user's browser supports HTML5 - it will
	have some extra frontend functionality.</p>
      <p>This field has different options on how to handle input values that aren't
	integers. By default, all non-integer values (e.g. 6.78) will round down (e.g. 6).</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="15%">
	  <col width="85%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td><tt class="docutils literal"><span class="pre">input</span></tt> <tt class="docutils literal"><span class="pre">text</span></tt> field</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">rounding_mode</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Inherited
	      options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">required</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">label</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">read_only</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><tt class="docutils literal"><span class="pre">field</span></tt></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/IntegerType.html" title="Symfony\Component\Form\Extension\Core\Type\IntegerType"><span class="pre">IntegerType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">rounding_mode</span></tt> [type: integer, default: <tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_DOWN</span></tt>]</dt>
	      <dd><p class="first">By default, if the user enters a non-integer number, it will be rounded
		  down. There are several other rounding methods, and each is a constant
		  on the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/DataTransformer/IntegerToLocalizedStringTransformer.html" title="Symfony\Component\Form\DataTransformer\IntegerToLocalizedStringTransformer"><span class="pre">IntegerToLocalizedStringTransformer</span></a></tt>:</p>
		<ul class="last">
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_DOWN</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round towards zero.</p>
		      </dd>
		    </dl>
		  </li>
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_FLOOR</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round towards negative infinity.</p>
		      </dd>
		    </dl>
		  </li>
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_UP</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round away from zero.</p>
		      </dd>
		    </dl>
		  </li>
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_CEILING</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round towards positive infinity.</p>
		      </dd>
		    </dl>
		  </li>
		</ul>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
      <div class="section" id="inherited-options">
	<h2>Inherited options<a class="headerlink" href="#inherited-options" title="Permalink to this headline">¶</a></h2>
	<p>These options inherit from the <a class="reference internal" href="field.html"><em>field</em></a> type:</p>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">required</span></tt> [type: Boolean, default: true]</dt>
	      <dd><p class="first last">The <tt class="docutils literal"><span class="pre">required</span></tt> option can be used to render an <a class="reference external" href="http://diveintohtml5.org/forms.html">HTML5 required attribute</a>.
		  Note that this is independent from validation: if you include the required
		  attribute on the field type but omit any required validation, the object
		  will appear to be valid to your application with a blank value. In other
		  words, this is a <em>nice</em> feature that will add client-side validation for
		  browsers that support HTML5. It's not, however, a replacement for true
		  server-side validation.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">label</span></tt> [type: string]</dt>
	      <dd><p class="first">Sets the label that will be used when rendering the field. If blank,
		  the label will be auto-generated based on the name of the field. The label
		  can also be directly set inside the template:</p>
		<div class="last highlight-jinja"><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">render_label</span><span class="o">(</span><span class="nv">form.name</span><span class="o">,</span> <span class="s1">'Name'</span><span class="o">)</span> <span class="cp">}}</span><span class="x"></span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">read_only</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If this option is true, the field will be rendered with the <tt class="docutils literal"><span class="pre">disabled</span></tt>
		  attribute so that the field is not editable.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">error_bubbling</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If true, any errors for this field will be passed to the parent field
		  or form. For example, if set to true on a normal field, any errors for
		  that field will be attached to the main form, not to the specific field.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="hidden Field Type" href="hidden.html">
      «&nbsp;hidden Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="language Field Type" href="language.html">
      language Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
