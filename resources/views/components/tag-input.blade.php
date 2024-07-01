<div class="flex flex-col">
    <label for="tags">Tags</label>
    <div data-tag-input="tags" data-tag-default-value="{{ $value }}" class="tag-input">
    
        <div class="tags">
            
        </div>
        <div contenteditable="true" class="fake-input"></div>
        <input hidden data-tag-container id="tags" name="tags" type="text">

        <div class="suggested">
            <span>one</span>
            <span>two</span>
            <span>three</span>
        </div>
        
    </div>
    <small class="ml-auto">Click a tag to remove it</small>
</div>