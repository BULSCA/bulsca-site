import { Command, Plugin } from "@ckeditor/ckeditor5-core";
import { ButtonView, ContextualBalloon, LabeledFieldView, View, createLabeledInputText, submitHandler, clickOutsideHandler, FocusCycler } from "@ckeditor/ckeditor5-ui";
import { toWidget, toWidgetEditable } from '@ckeditor/ckeditor5-widget/src/utils';
import Widget from '@ckeditor/ckeditor5-widget/src/widget';
import { icons } from '@ckeditor/ckeditor5-core';
import { FocusTracker, KeystrokeHandler } from "@ckeditor/ckeditor5-utils";
import { findAttributeRange } from "@ckeditor/ckeditor5-typing";
import { ClickObserver } from "@ckeditor/ckeditor5-engine";

class FileLink extends Plugin {

    static get requires() {                                                    // ADDED
        return [ Widget, ContextualBalloon ];
    }

    init() {
        console.log("FileLink plugin was initialized!");


        const editor = this.editor;

        

        this._balloon = this.editor.plugins.get( ContextualBalloon );
        this.formView = this._createFormView();

        this.editor.commands.add('afl', new FileLinkCommand(this.editor))



        
        

    

        editor.ui.componentFactory.add('filelink', () => {

            const button = new ButtonView();

            button.set({
                label: "FileLink",
                withText: true
            });

            
            button.on('execute', () => {
             
                this._showUI();
            })

   

            return button;

        })

        

        this._defineSchema();
        this._defineConverters();
    }

    _defineSchema() {
        const schema = this.editor.model.schema;

        schema.register('fileLink', {
            inheritAllFrom: '$blockObject',
            allowAttributes: ['title', 'href']
   
        });

    

        
    }

    _defineConverters() {
        const conversion = this.editor.conversion;

        


        conversion.for('downcast').elementToStructure({
            model: 'fileLink',
            view: (modelElement, { writer }) => {

                const title = modelElement.getAttribute('title')
                const href = modelElement.getAttribute('href')

                const d = writer.createContainerElement('div', {class: 'file-link'}, [
                    writer.createContainerElement('a', { href: href}, [
                        writer.createContainerElement('div', null, [ writer.createUIElement("h3", null, function(dd) {
                            const de = this.toDomElement(dd);
                            de.innerHTML = title
                            return de
                        }), writer.createUIElement('small', null, function (domDocument)  {
                            const domElement = this.toDomElement(domDocument)
                            domElement.innerHTML = "Click to download"
                            return domElement
                        })])
                        ,
                        writer.createUIElement('div', null, function(domDocument) {
                            const domElement = this.toDomElement(domDocument)
                            domElement.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>`
                            return domElement
                        })
                    ])
                ])

                
                return toWidget(d, writer, { label: "file link widget"});
            }
        })

        conversion.for('upcast').elementToElement({
            model:  ( viewElement, conversionApi ) => {
                const modelWriter = conversionApi.writer;

                const a = viewElement._children[0];
               
                const title = a._children[0]._children[0]._children[0]._textData
              
        
                return modelWriter.createElement( 'fileLink', { title: title, href: a.getAttribute('href') } );
            },
            view: {
                name: 'div',
                classes: ['file-link'],
                
            },
            
        })






        
    }

    _createFormView() {
        const editor = this.editor;
        const formView = new FormView( editor.locale );

        this.listenTo( formView, 'submit', () => {
            const title = formView.titleInp.fieldView.element.value
            const href = formView.hrefInp.fieldView.element.value

            editor.execute('afl', { title: title, href: href});

            // editor.model.change( writer => {

            //     editor.model.insertContent(writer.createElement('fileLink', { title: title, href: href}))
            // } );

            this._hideUI();

        } );

        this.listenTo( formView, 'cancel', () => {
            this._hideUI();
        } );


        formView.keystrokes.set( 'Esc', ( data, cancel ) => {
            this._hideUI();
            cancel();
        } );

        // Hide the form view when clicking outside the balloon.
        clickOutsideHandler( {
            emitter: formView,
            activator: () => this._balloon.visibleView === formView,
            contextElements: [ this._balloon.view.element ],
            callback: () => this._hideUI()
        } );

        return formView;
    }

    _getBalloonPositionData() {
        const view = this.editor.editing.view;
        const viewDocument = view.document;
        let target = null;

        // Set a target position by converting view selection range to DOM.
        target = () => view.domConverter.viewRangeToDom(
            viewDocument.selection.getFirstRange()
        );

        return {
            target
        };
    }

    _hideUI() {
        this.formView.titleInp.fieldView.value = '';
        this.formView.hrefInp.fieldView.value = '';
        this.formView.element.reset();

        this._balloon.remove( this.formView );

        // Focus the editing view after closing the form view.
        this.editor.editing.view.focus();
    }

    _showUI() {
        this._balloon.add( {
            view: this.formView,
            position: this._getBalloonPositionData()
        } );



        const commandValue = this.editor.commands.get('afl').value;

        if ( commandValue ) {
            this.formView.titleInp.fieldView.value = commandValue.title
            this.formView.hrefInp.fieldView.value = commandValue.href
        }


        this.formView.focus();
    }
}

class FormView extends View {
    constructor( locale ) {
        super( locale );

        this.titleInp = this._createInput('Title')
        this.hrefInp = this._createInput('Href')

        this.focusTracker = new FocusTracker()
        this.keystrokes = new KeystrokeHandler()

        
        this._focusCycler = new FocusCycler( {
            focusables: this.childViews,
            focusTracker: this.focusTracker,
            keystrokeHandler: this.keystrokes,
            actions: {
                // Navigate form fields backwards using the Shift + Tab keystroke.
                focusPrevious: 'shift + tab',

                // Navigate form fields forwards using the Tab key.
                focusNext: 'tab'
            }
        } );

        // Create the save and cancel buttons.
        this.saveButtonView = this._createButton(
            'Save', icons.check, 'ck-button-save'
        );
        // Set the type to 'submit', which will trigger
        // the submit event on entire form when clicked.
        this.saveButtonView.type = 'submit';

        this.cancelButtonView = this._createButton(
            'Cancel', icons.cancel, 'ck-button-cancel'
        );

        this.cancelButtonView.delegate( 'execute' ).to( this, 'cancel' );

        this.childViews = this.createCollection([
            this.titleInp,
            this.hrefInp,
            this.saveButtonView,
            this.cancelButtonView
        ])

        this.setTemplate( {
            tag: 'form',
            attributes: {
                class: [ 'ck', 'ck-fl-form' ],
                tabindex: '-1'
            },
            children: this.childViews
        } );
    }

    render() {
        super.render();

        // Submit the form when the user clicked the save button
        // or pressed enter in the input.
        submitHandler( {
            view: this
        } );

        this.childViews._items.forEach( view => {
            // Register the view in the focus tracker.
            this.focusTracker.add( view.element );
        } );

        // Start listening for the keystrokes coming from #element.
        this.keystrokes.listenTo( this.element );
    }

    focus() {
        this.childViews.first.focus();
      
    }

    _createInput( label ) {
        const li = new LabeledFieldView(this.locale, createLabeledInputText)

        li.label = label;

        return li;
    }

    _createButton( label, icon, className ) {
        const button = new ButtonView();

        button.set( {
            label,
            icon,
            tooltip: true,
            class: className
        } );

        return button;
    }

    
    destroy() {
        super.destroy();

        this.focusTracker.destroy();
        this.keystrokes.destroy();
    }

}

class FileLinkCommand extends Command {




    execute( { title, href }) {
        const model = this.editor.model
        const selection = model.document.selection
        





        
        model.change(writer => {
      
          
                this.editor.model.insertContent(writer.createElement('fileLink', { title: title, href: href }))
            
                
            
        })
    }

    refresh() {
        const model = this.editor.model;
        
        const selection = model.document.selection;
        const firstRange = selection.getFirstRange();

        


        if (!selection.isCollapsed){

            const element = firstRange.getContainedElement();
    
            this.value = { title: element.getAttribute('title'), href: element.getAttribute('href')}
           
        } else {
            this.value = null
        }
        


        this.isEnabled = true

        
   
    }


}

export default FileLink;