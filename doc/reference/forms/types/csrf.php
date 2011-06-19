<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">csrf Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="csrf-field-type">
      <span id="index-0"></span><h1>csrf Field Type<a class="headerlink" href="#csrf-field-type" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">csrf</span></tt> type is a hidden input field containing a CSRF token.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="16%">
	  <col width="84%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td><tt class="docutils literal"><span class="pre">input</span></tt> <tt class="docutils literal"><span class="pre">hidden</span></tt> field</td>
	  </tr>
	  <tr><td>Options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">csrf_provider</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">page_id</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">property_path</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Inherited
	      options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><tt class="docutils literal"><span class="pre">hidden</span></tt></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Csrf/Type/CsrfType.html" title="Symfony\Component\Form\Extension\Csrf\Type\CsrfType"><span class="pre">CsrfType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="options">
	<h2>Options<a class="headerlink" href="#options" title="Permalink to this headline">¶</a></h2>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">csrf_provider</span></tt> [type: <tt class="docutils literal"><span class="pre">Symfony\Component\Form\CsrfProvider\CsrfProviderInterface</span></tt>]</dt>
	      <dd><p class="first last">The <tt class="docutils literal"><span class="pre">CsrfProviderInterface</span></tt> object that should generate the CSRF token.
		  If not set, this defaults to the default provider.</p>
	      </dd>
	    </dl>
	  </li>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">page_id</span></tt> [type: string]</dt>
	      <dd><p class="first last">An optional page identifier used to generate the CSRF token.</p>
	      </dd>
	    </dl>
	  </li>
	</ul>
	<ul>
	  <li><dl class="first docutils">
	      <dt><tt class="docutils literal"><span class="pre">property_path</span></tt> [type: any, default: the field's value]</dt>
	      <dd><p class="first">Fields display a property value of the form's domain object by default. When
		  the form is submitted, the submitted value is written back into the object.</p>
		<p class="last">If you want to override the property that a field reads from and writes to,
		  you can set the <tt class="docutils literal"><span class="pre">property_path</span></tt> option. Its default value is the field's
		  name.</p>
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
	      <dt><tt class="docutils literal"><span class="pre">error_bubbling</span></tt> [type: Boolean, default: true]</dt>
	      <dd><blockquote class="first last">
		  <div><p>If true, any errors for this field will be passed to the parent field
		      or form. For example, if set to true on a normal field, any errors for
		      that field will be attached to the main form, not to the specific field.</p>
		</div></blockquote>
	      </dd>
	    </dl>
	  </li>
	</ul>
      </div>
    </div>


    

  </div>

  <div class="navigation">
    <a accesskey="P" title="country Field Type" href="country.html">
      «&nbsp;country Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="date Field Type" href="date.html">
      date Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
