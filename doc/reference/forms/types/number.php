<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">number Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="number-field-type">
      <span id="index-0"></span><h1>number Field Type<a class="headerlink" href="#number-field-type" title="Permalink to this headline">¶</a></h1>
      <p>Renders an input text field and specializes in handling number input. This
	type offers different options for the precision, rounding, and grouping that
	you want to use for your number.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="16%">
	  <col width="84%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td><tt class="docutils literal"><span class="pre">input</span></tt> <tt class="docutils literal"><span class="pre">text</span></tt> field</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">rounding_mode</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">precision</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">grouping</span></tt></li>
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
	    <td><a class="reference internal" href="field.html"><em>field</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/NumberType.html" title="Symfony\Component\Form\Extension\Core\Type\NumberType"><span class="pre">NumberType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">precision</span></tt> [type: integer, default: Locale-specific (usually around <tt class="docutils literal"><span class="pre">3</span></tt>)]</dt>
	      <dd><p class="first last">This specifies how many decimals will be allowed until the field rounds
		  the submitted value (via <tt class="docutils literal"><span class="pre">rounding_mode</span></tt>). For example, if <tt class="docutils literal"><span class="pre">precision</span></tt>
		  is set to <tt class="docutils literal"><span class="pre">2</span></tt>, a submitted value of <tt class="docutils literal"><span class="pre">20.123</span></tt> will be rounded to,
		  for example, <tt class="docutils literal"><span class="pre">20.12</span></tt> (depending on your <tt class="docutils literal"><span class="pre">rounding_mode</span></tt>).</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">rounding_mode</span></tt> [type: integer, default: <tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_DOWN</span></tt>]</dt>
	      <dd><p class="first">If a submitted number needs to be rounded (based on the <tt class="docutils literal"><span class="pre">precision</span></tt>
		  option), you have several configurable options for that rounding. Each
		  option is a constant on the <tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/DataTransformer/IntegerToLocalizedStringTransformer.html" title="Symfony\Component\Form\DataTransformer\IntegerToLocalizedStringTransformer"><span class="pre">IntegerToLocalizedStringTransformer</span></a></tt>:</p>
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
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_HALFDOWN</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round towards "nearest neighbor" unless both neighbors
			  are equidistant, in which case round down.</p>
		      </dd>
		    </dl>
		  </li>
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_HALFEVEN</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round towards the "nearest neighbor" unless both
			  neighbors are equidistant, in which case, round towards the even
			  neighbor.</p>
		      </dd>
		    </dl>
		  </li>
		  <li><dl class="first docutils">
		      <dt><tt class="docutils literal"><span class="pre">IntegerToLocalizedStringTransformer::ROUND_HALFUP</span></tt></dt>
		      <dd><p class="first last">Rounding mode to round towards "nearest neighbor" unless both neighbors
			  are equidistant, in which case round up.</p>
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
	<h2>Inherited Options<a class="headerlink" href="#inherited-options" title="Permalink to this headline">¶</a></h2>
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
    <a accesskey="P" title="money Field Type" href="money.html">
      «&nbsp;money Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="password Field Type" href="password.html">
      password Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
