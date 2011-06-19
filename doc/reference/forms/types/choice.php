<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">choice Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="choice-field-type">
      <span id="index-0"></span><h1>choice Field Type<a class="headerlink" href="#choice-field-type" title="Permalink to this headline">¶</a></h1>
      <p>A multi-purpose field used to allow the user to "choose" one or more options.
	It can be rendered as a <tt class="docutils literal"><span class="pre">select</span></tt> tag, radio buttons, or checkboxes.</p>
      <p>To use this field, you must specify <em>either</em> the <tt class="docutils literal"><span class="pre">choice_list</span></tt> or <tt class="docutils literal"><span class="pre">choices</span></tt>
	option.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="14%">
	  <col width="86%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td>can be various tags (see below)</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">choices</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">choice_list</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">multiple</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">expanded</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">preferred_choices</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Inherited
	      options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">required</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">label</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">read_only</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="form.html"><em>form</em></a> (if expanded), <tt class="docutils literal"><span class="pre">field</span></tt> otherwise</td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/ChoiceType.html" title="Symfony\Component\Form\Extension\Core\Type\ChoiceType"><span class="pre">ChoiceType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="example-usage">
	<h2>Example Usage<a class="headerlink" href="#example-usage" title="Permalink to this headline">¶</a></h2>
	<p>The easiest way to use this field is to specify the choices directly via the
	  <tt class="docutils literal"><span class="pre">choices</span></tt> option. The key of the array becomes the value that's actually
	  set on your underlying object (e.g. <tt class="docutils literal"><span class="pre">m</span></tt>), while the value is what the
	  user sees on the form (e.g. <tt class="docutils literal"><span class="pre">Male</span></tt>).</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="s1">'choice'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'choices'</span>   <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'m'</span> <span class="o">=&gt;</span> <span class="s1">'Male'</span><span class="p">,</span> <span class="s1">'f'</span> <span class="o">=&gt;</span> <span class="s1">'Female'</span><span class="p">),</span>
    <span class="s1">'required'</span>  <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>By setting <tt class="docutils literal"><span class="pre">multiple</span></tt> to true, you can allow the user to choose multiple
	  values. The widget will be rendered as a multiple <tt class="docutils literal"><span class="pre">select</span></tt> tag or a series
	  of checkboxes depending on the <tt class="docutils literal"><span class="pre">expanded</span></tt> option:</p>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'availability'</span><span class="p">,</span> <span class="s1">'choice'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'choices'</span>   <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span>
        <span class="s1">'morning'</span>   <span class="o">=&gt;</span> <span class="s1">'Morning'</span><span class="p">,</span>
        <span class="s1">'afternoon'</span> <span class="o">=&gt;</span> <span class="s1">'Afternoon'</span><span class="p">,</span>
        <span class="s1">'evening'</span>   <span class="o">=&gt;</span> <span class="s1">'Evening'</span><span class="p">,</span>
    <span class="p">),</span>
    <span class="s1">'multiple'</span>  <span class="o">=&gt;</span> <span class="k">true</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
	<p>You can also use the <tt class="docutils literal"><span class="pre">choice_list</span></tt> option, which takes an object that can
	  specify the choices for your widget.</p>
      </div>
      <div class="section" id="select-tag-checkboxes-or-radio-buttons">
	<span id="forms-reference-choice-tags"></span><h2>Select tag, Checkboxes or Radio Buttons<a class="headerlink" href="#select-tag-checkboxes-or-radio-buttons" title="Permalink to this headline">¶</a></h2>
	<p>This field may be rendered as one of several different HTML fields, depending
	  on the <tt class="docutils literal"><span class="pre">expanded</span></tt> and <tt class="docutils literal"><span class="pre">multiple</span></tt> options:</p>
	<table border="1" class="docutils">
	  <colgroup>
	    <col width="68%">
	    <col width="16%">
	    <col width="16%">
	  </colgroup>
	  <thead valign="bottom">
	    <tr><th class="head">element type</th>
	      <th class="head">expanded</th>
	      <th class="head">multiple</th>
	    </tr>
	  </thead>
	  <tbody valign="top">
	    <tr><td>select tag</td>
	      <td>false</td>
	      <td>false</td>
	    </tr>
	    <tr><td>select tag (with <tt class="docutils literal"><span class="pre">multiple</span></tt> attribute)</td>
	      <td>false</td>
	      <td>true</td>
	    </tr>
	    <tr><td>radio buttons</td>
	      <td>true</td>
	      <td>false</td>
	    </tr>
	    <tr><td>checkboxes</td>
	      <td>true</td>
	      <td>true</td>
	    </tr>
	  </tbody>
	</table>
      </div>
      <div class="section" id="adding-an-empty-value">
	<h2>Adding an "empty value"<a class="headerlink" href="#adding-an-empty-value" title="Permalink to this headline">¶</a></h2>
	<p>If you're using the non-expanded version of the type (i.e. a <tt class="docutils literal"><span class="pre">select</span></tt> tag)
	  element and you'd like to have a blank entry (e.g. "Choose an option") at
	  the top of the select box, you can easily do so by doing the following:</p>
	<ul class="simple">
	  <li>Set the <tt class="docutils literal"><span class="pre">multiple</span></tt> option to false;</li>
	  <li>Set the <tt class="docutils literal"><span class="pre">required</span></tt> option to false or explicitly pass in the <tt class="docutils literal"><span class="pre">empty_value</span></tt>
	    option in the template (as shown below).</li>
	</ul>
	<p>If <tt class="docutils literal"><span class="pre">required</span></tt> is false, a blank choice will display at the top of the select
	  box. To customize what that entry says (or if you have <tt class="docutils literal"><span class="pre">required</span></tt> set to
	  <tt class="docutils literal"><span class="pre">true</span></tt>), add the following when rendering the field:</p>
	<div class="configuration-block jsactive clearfix">
	  <ul class="simple" style="height: 76px; ">
	    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.foo_choices</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'empty_value'</span><span class="o">:</span> <span class="s1">'Choose an option'</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'foo_choices'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span><span class="s1">'empty_value'</span> <span class="o">=&gt;</span> <span class="s1">'Choose an option'</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
		</pre></div>
	      </div>
	    </li>
	  </ul>
	</div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">choices</span></tt> [type: array]</dt>
	      <dd><p class="first">This is the most basic way to specify the choices that should be used
		  by this field. The <tt class="docutils literal"><span class="pre">choices</span></tt> option is an array, where the array key
		  is the item value and the array value is the item's label:</p>
		<div class="last highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'gender'</span><span class="p">,</span> <span class="s1">'choice'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'m'</span> <span class="o">=&gt;</span> <span class="s1">'Male'</span><span class="p">,</span> <span class="s1">'f'</span> <span class="o">=&gt;</span> <span class="s1">'Female'</span><span class="p">)</span>
<span class="p">));</span>
		  </pre></div>
		</div>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">choice_list</span></tt> [type: <tt class="docutils literal"><span class="pre">Symfony\Component\Form\ChoiceList\ChoiceListInterface</span></tt>]</dt>
	      <dd><p class="first last">This is one way of specifying the options to be used for this field.
		  The <tt class="docutils literal"><span class="pre">choice_list</span></tt> option must be an instance of the <tt class="docutils literal"><span class="pre">ChoiceListInterface</span></tt>.
		  For more advanced cases, a custom class that implements the interface
		  can be created to supply the choices.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">multiple</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If true, the user will be able to select multiple options (as opposed
		  to choosing just one option). Depending on the value of the <tt class="docutils literal"><span class="pre">expanded</span></tt>
		  option, this will render either a select tag or checkboxes if true and
		  a select tag or radio buttons if false.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">expanded</span></tt> [type: Boolean, default: false]</dt>
	      <dd><p class="first last">If set to true, radio buttons or checkboxes will be rendered (depending
		  on the <tt class="docutils literal"><span class="pre">multiple</span></tt> value). If false, a select element will be rendered.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">preferred_choices</span></tt> [type: array]</dt>
	      <dd><p class="first">If this option is specified, then a sub-set of the total number of options
		  will be moved to the top of the select menu. The following would move
		  the "Baz" option to the top, with a visual separator between it and the
		  rest of the options:</p>
		<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'foo_choices'</span><span class="p">,</span> <span class="s1">'choice'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'foo'</span> <span class="o">=&gt;</span> <span class="s1">'Foo'</span><span class="p">,</span> <span class="s1">'bar'</span> <span class="o">=&gt;</span> <span class="s1">'Bar'</span><span class="p">,</span> <span class="s1">'baz'</span> <span class="o">=&gt;</span> <span class="s1">'Baz'</span><span class="p">),</span>
    <span class="s1">'preferred_choices'</span> <span class="o">=&gt;</span> <span class="k">array</span><span class="p">(</span><span class="s1">'baz'</span><span class="p">),</span>
<span class="p">));</span>
		  </pre></div>
		</div>
		<p>Note that preferred choices are only meaningful when rendering as a
		  <tt class="docutils literal"><span class="pre">select</span></tt> element (i.e. <tt class="docutils literal"><span class="pre">expanded</span></tt> is false). The preferred choices
		  and normal choices are separated visually by a set of dotted lines
		  (i.e. <tt class="docutils literal"><span class="pre">-------------------</span></tt>). This can be customized when rendering
		  the field:</p>
		<div class="last configuration-block jsactive clearfix">
		  <ul class="simple" style="height: 76px; ">
		    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 690px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.foo_choices</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'separator'</span><span class="o">:</span> <span class="s1">'====='</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
			</pre></div>
		      </div>
		    </li>
		    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 690px; "><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'foo_choices'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span><span class="s1">'separator'</span> <span class="o">=&gt;</span> <span class="s1">'====='</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
			</pre></div>
		      </div>
		    </li>
		  </ul>
		</div>
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
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="checkbox Field Type" href="checkbox.html">
      «&nbsp;checkbox Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="collection Field Type" href="collection.html">
      collection Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
