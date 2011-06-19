<?php include(__DIR__.'/../../../_doc.php')?>
<div class="column_02">

  <div class="box_title">
    <h1 class="title_01">language Field Type</h1>
  </div>
  
  

  <div class="box_article doc_page">

    
    
    <div class="section" id="language-field-type">
      <span id="index-0"></span><h1>language Field Type<a class="headerlink" href="#language-field-type" title="Permalink to this headline">¶</a></h1>
      <p>The <tt class="docutils literal"><span class="pre">language</span></tt> type is a subset of the <tt class="docutils literal"><span class="pre">ChoiceType</span></tt> that allows the user
	to select from a large list of languages. As an added bonus, the language names
	are displayed in the language of the user.</p>
      <p>The "value" for each locale is either the two letter ISO639-1 <em>language</em> code
	(e.g. <tt class="docutils literal"><span class="pre">fr</span></tt>).</p>
      <div class="admonition-wrapper">
	<div class="note"></div><div class="admonition admonition-note"><p class="first admonition-title">Note</p>
	  <p class="last">The locale of your user is guessed using <a class="reference external" href="http://php.net/manual/en/locale.getdefault.php">Locale::getDefault()</a></p>
      </div></div>
      <p>Unlike the <tt class="docutils literal"><span class="pre">choice</span></tt> type, you don't need to specify a <tt class="docutils literal"><span class="pre">choices</span></tt> or
	<tt class="docutils literal"><span class="pre">choice_list</span></tt> option as the field type automatically uses a large list
	of languages. You <em>can</em> specify either of these options manually, but then
	you should just use the <tt class="docutils literal"><span class="pre">choice</span></tt> type directly.</p>
      <table border="1" class="docutils">
	<colgroup>
	  <col width="15%">
	  <col width="85%">
	</colgroup>
	<tbody valign="top">
	  <tr><td>Rendered as</td>
	    <td>can be various tags (see <a class="reference internal" href="choice.html#forms-reference-choice-tags"><em>Select tag, Checkboxes or Radio Buttons</em></a>)</td>
	  </tr>
	  <tr><td>Inherited
	      options</td>
	    <td><ul class="first last simple">
		<li><tt class="docutils literal"><span class="pre">multiple</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">expanded</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">preferred_choices</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">required</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">label</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">read_only</span></tt></li>
		<li><tt class="docutils literal"><span class="pre">error_bubbling</span></tt></li>
	      </ul>
	    </td>
	  </tr>
	  <tr><td>Parent type</td>
	    <td><a class="reference internal" href="choice.html"><em>choice</em></a></td>
	  </tr>
	  <tr><td>Class</td>
	    <td><tt class="docutils literal"><a class="reference external" href="http://api.symfony.com/2.0/Symfony/Component/Form/Extension/Core/Type/LanguageType.html" title="Symfony\Component\Form\Extension\Core\Type\LanguageType"><span class="pre">LanguageType</span></a></tt></td>
	  </tr>
	</tbody>
      </table>
      <div class="section" id="inherited-options">
	<h2>Inherited Options<a class="headerlink" href="#inherited-options" title="Permalink to this headline">¶</a></h2>
	<p>These options inherit from the <a class="reference internal" href="choice.html"><em>choice</em></a> type:</p>
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
		    <li class="selected"><em><a href="#">Twig</a></em><div class="highlight-jinja" style="width: 614px; display: block; "><div class="highlight"><pre><span class="cp">{{</span> <span class="nv">form_widget</span><span class="o">(</span><span class="nv">form.foo_choices</span><span class="o">,</span> <span class="o">{</span> <span class="s1">'separator'</span><span class="o">:</span> <span class="s1">'====='</span> <span class="o">})</span> <span class="cp">}}</span><span class="x"></span>
			</pre></div>
		      </div>
		    </li>
		    <li><em><a href="#">PHP</a></em><div class="highlight-php" style="display: none; width: 614px; "><div class="highlight"><pre><span class="o">&lt;?</span><span class="nx">php</span> <span class="k">echo</span> <span class="nv">$view</span><span class="p">[</span><span class="s1">'form'</span><span class="p">]</span><span class="o">-&gt;</span><span class="na">widget</span><span class="p">(</span><span class="nv">$form</span><span class="p">[</span><span class="s1">'foo_choices'</span><span class="p">],</span> <span class="k">array</span><span class="p">(</span><span class="s1">'separator'</span> <span class="o">=&gt;</span> <span class="s1">'====='</span><span class="p">))</span> <span class="cp">?&gt;</span><span class="x"></span>
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
    <a accesskey="P" title="integer Field Type" href="integer.html">
      «&nbsp;integer Field Type
    </a><span class="separator">|</span>
    <a accesskey="N" title="locale Field Type" href="locale.html">
      locale Field Type&nbsp;»
    </a>
  </div>

  <div class="box_hr"><hr></div>

</div>
