<div class="PrependAppendField-group $GroupExtraClass">
    <% if $PrependAppend == "append" %>
      <input $AttributesHTML class="$extraClass">
      <span class="PrependAppendField-append-label">
        $PrependAppendText
      </span>
    <% else %>
      <span class="PrependAppendField-prepend-label">
        $PrependAppendText
      </span>
      <input $AttributesHTML class="$extraClass">
    <% end_if %>
</div>
