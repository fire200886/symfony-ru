<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">
  <div class="box_title">
    <h1 class="title_01">money Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="money-field-type">
      <span id="index-0"></span><h1>money Field Type<a class="headerlink" href="#money-field-type" title="Permalink to this headline">¶</a></h1>
      <p>Renders an input text field and specializes in handling submitted "money"
	data.</p>
      <p>This field type allows you to specify a currency, whose symbol is rendered
	next to the text field. There are also several other options for customizing
	how the input and output of the data is handled.</p>
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
		<li><tt class="docutils literal"><span class="pre">currency</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">divisor</span></tt></li>
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
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/MoneyType.html" title="Symfony\Component\Form\Extension\Core\Type\MoneyType"><span class="pre">MoneyType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">currency</span></tt> [type: string, default <tt class="docutils literal"><span class="pre">EUR</span></tt>]</dt>
	      <dd><p class="first">Specifies the currency that the money is being specified in. This determines
		  the currency symbol that should be shown by the text box. Depending on
		  the currency - the currency symbol may be shown before or after the input
		  text field.</p>
		<p class="last">This can also be set to false to hide the currency symbol.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">divisor</span></tt> [type: integer, default: <tt class="docutils literal"><span class="pre">1</span></tt>]</dt>
	      <dd><p class="first">If, for some reason, you need to divide your starting value by a number
		  before rendering it to the user, you can use the <tt class="docutils literal"><span class="pre">divisor</span></tt> option.
		  For example:</p>
		<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'price'</span><span class="p">,</span> <span class="s1">'money'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'divisor'</span> <span class="o">=&gt;</span> <span class="mi">100</span><span class="p">,</span>
<span class="p">));</span>
		  </pre></div>
		</div>
		<p class="last">In this case, if the <tt class="docutils literal"><span class="pre">price</span></tt> field is set to <tt class="docutils literal"><span class="pre">9900</span></tt>, then the value
		  <tt class="docutils literal"><span class="pre">99</span></tt> will actually be rendered to the user. When the user submits the
		  value <tt class="docutils literal"><span class="pre">99</span></tt>, it will be multiplied by <tt class="docutils literal"><span class="pre">100</span></tt> and <tt class="docutils literal"><span class="pre">9900</span></tt> will ultimately
		  be set back on your object.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">precision</span></tt> [type: integer, default: 2]</dt>
	      <dd><p class="first last">For some reason, if you need some precision other than 2 decimal places,
		  you can modify this value. You probably won't need to do this unless,
		  for example, you want to round to the nearest dollar (set the precision
		  to <tt class="docutils literal"><span class="pre">0</span></tt>).</p>
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
    <a accesskey="P" title="locale Field Type" href="locale.html">
      «&nbsp;locale Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="number Field Type" href="number.html">
      number Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
