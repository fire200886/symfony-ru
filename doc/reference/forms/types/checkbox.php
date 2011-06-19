<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">checkbox Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="checkbox-field-type">
      <span id="index-0"></span><h1>checkbox Field Type<a class="headerlink" href="#checkbox-field-type" title="Permalink to this headline">¶</a></h1>
      <p>Creates a single input checkbox. This should always be used for a field that
	has a Boolean value: if the box is checked, the field will be set to true,
	if the box is unchecked, the value will be set to false.</p>
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
		<li><tt class="docutils literal"><span class="pre">value</span></tt></li>
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
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/CheckboxType.html" title="Symfony\Component\Form\Extension\Core\Type\CheckboxType"><span class="pre">CheckboxType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="example-usage">
	<h2>Example Usage<a class="headerlink" href="#example-usage" title="Permalink to this headline">¶</a></h2>
	<div class="highlight-php"><div class="highlight"><pre><span class="nv">$builder</span><span class="o">-&gt;</span><span class="na">add</span><span class="p">(</span><span class="s1">'public'</span><span class="p">,</span> <span class="s1">'checkbox'</span><span class="p">,</span> <span class="k">array</span><span class="p">(</span>
    <span class="s1">'label'</span>     <span class="o">=&gt;</span> <span class="s1">'Show this entry publicly?'</span><span class="p">,</span>
    <span class="s1">'required'</span>  <span class="o">=&gt;</span> <span class="k">false</span><span class="p">,</span>
<span class="p">));</span>
	  </pre></div>
	</div>
      </div>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">value</span></tt> [type: mixed, default: 1]</dt>
	      <dd><p class="first last">The value that's actually used as the value for the checkbox. This does
		  not affect the value that's set on your object.</p>
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
    <a accesskey="P" title="birthday Field Type" href="birthday.html">
      «&nbsp;birthday Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="choice Field Type" href="choice.html">
      choice Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
