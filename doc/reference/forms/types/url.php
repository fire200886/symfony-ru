<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">url Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="url-field-type">
      <span id="index-0"></span><h1>url Field Type<a class="headerlink" href="#url-field-type" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">url</span></tt> field is a text field that prepends the submitted value with
	a given protocol (e.g. <tt class="docutils literal"><span class="pre">http://</span></tt>) if the submitted value doesn't already
	have a protocol.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="16%">
	  <col width="84%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td><tt class="docutils literal"><span class="pre">input</span> <span class="pre">url</span></tt> field</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">default_protocol</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">max_length</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">required</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">label</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">read_only</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">trim</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="text.html"><em>text</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/UrlType.html" title="Symfony\Component\Form\Extension\Core\Type\UrlType"><span class="pre">UrlType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><p class="first"><tt class="docutils literal"><span class="pre">default_protocol</span></tt> [type: string, default: <tt class="docutils literal"><span class="pre">http</span></tt>]</p>
	    <blockquote>
	      <div><p>If a value is submitted that doesn't begin with some protocol (e.g. <tt class="docutils literal"><span class="pre">http://</span></tt>,
		  <tt class="docutils literal"><span class="pre">ftp://</span></tt>, etc), this protocol will be prepended to the string when
		  the data is bound to the form.</p>
	    </div></blockquote>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">max_length</span></tt> [type: integer]</dt>
	      <dd><p class="first last">This option is used to add a <tt class="docutils literal"><span class="pre">max_length</span></tt> attribute, which is used by
		  some browsers to limit the amount of text in a field.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
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
	      <dt><tt class="docutils literal"><span class="pre">trim</span></tt> [type: Boolean, default: true]</dt>
	      <dd><p class="first last">If true, the whitespace of the submitted string value will be stripped
		  via the <tt class="docutils literal"><span class="pre">trim()</span></tt> function when the data is bound. This guarantees that
		  if a value is submitted with extra whitespace, it will be removed before
		  the value is merged back onto the underlying object.</p>
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
    <a accesskey="P" title="timezone Field Type" href="timezone.html">
      «&nbsp;timezone Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="Twig Template Form Function Reference" href="../twig_reference.html">
      Twig Template Form Function Reference&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
