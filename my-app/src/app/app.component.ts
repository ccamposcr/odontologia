import { Component } from '@angular/core';
import "../assets/js/artyom.window.min.js";
import { TextAttribute } from '@angular/compiler/src/render3/r3_ast';
declare const Artyom: any;
//https://sdkcarlos.github.io/sites/artyom.html
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'my-app';
  public artyom;

  addCommands(){
    let that = this;
    let commands = [
        {
            indexes:["abrir expediente", "buscar expediente", "expediente"],
            action:function(i){
               that.artyom.say("Cúal es el nombre del expediente?",{
                   onEnd:function(){
                        that.artyom.clearGarbageCollection();
                        function callbackOnResult(text){
                            console.log(text);
                            if(text.indexOf('salir') !== -1){
                                console.log('Saliendo');
                                that.initArtyom();
                            }
                        }
                        function callbackOnStart(){
                            console.log("Dictation started by the user");
                        }
                        function callbackOnEnd(){
                            console.log("Dictation stopped by the user");
                            that.initArtyom();
                        }
                        that.initDictation(callbackOnResult,callbackOnStart,callbackOnEnd);
                    }
               });
            }
        },
        {
            indexes:["18"],
            action:function(i){
                console.log('CCO ' + i);
                switch(i){
                    case 0:
                        //that.artyom.say("18 marcada");
                        break;
                }
                function beforePromptCallback(){
                    //that.artyom.dontObey();
                    console.log("Before ask");
                }

                function onStartPromptCallback(){
                    console.log("The prompt is being executed");
                }

                function onEndPromptCallback(){
                    console.log("The prompt has been executed succesfully");
                }

                function onMatchCallback(i){
                    var action;

                    if(i == 0){ 
                        action =  () => {
                            that.artyom.say("El estado es 1");
                        }
                    }
            
                    if(i == 1){ 
                        action =  () => {
                            that.artyom.say("El estado es 2");
                        }
                    }
            
                    if(i == 2){
                        action = () => {
                            that.artyom.say("El estado es 3");
                        }
                    }
            
                    // A function needs to be returned in onMatch event
                    // in order to accomplish what you want to execute
                    return action; 
                }

                that.initPrompt("Cúal es el estado?",["1","2","3"], beforePromptCallback, onStartPromptCallback, onEndPromptCallback, onMatchCallback);
            }
        }
    ];

    this.artyom.addCommands(commands);
  }

  initPrompt(question, options,beforePromptCallback, onStartPromptCallback, onEndPromptCallback, onMatchCallback){
    var that = this;
    that.artyom.newPrompt({
        question: question,
        options:options,
        beforePrompt() {
            beforePromptCallback();
        },
        onStartPrompt() {
            onStartPromptCallback();
        },
        onEndPrompt(){
           onEndPromptCallback();
        },
        onMatch(i){ // i returns the index of the given options
            return onMatchCallback(i);
        }
    });
  }

  initDictation(callbackOnResult, callbackOnStart, callbackOnEnd){
    let that = this;
    that.artyom.fatality();

    let UserDictation = that.artyom.newDictation({
        continuous:false, // Enable continuous if HTTPS connection
        onResult:function(text){
            callbackOnResult(text);
        },
        onStart:function(){
            callbackOnStart();
        },
        onEnd:function(){
            callbackOnEnd();
        }
    });
    
    UserDictation.start();
  }

  initArtyom(){
      let that = this;
      this.artyom.fatality();
    // Start the commands !
    setTimeout(function(){
        that.artyom.initialize({
            lang: "es-ES",
            continuous: true, // Listen forever
            soundex: true,// Use the soundex algorithm to increase accuracy
            debug: true, // Show messages in the console
            executionKeyword: "por favor",
            obeyKeyword: "iniciar",
            listen: true, // Start to listen commands !
            name: ""
        }).then(() => {
            console.log("Artyom has been succesfully initialized");
            that.addCommands();
        }).catch((err) => {
            console.error("Artyom couldn't be initialized: ", err);
        });
    },250);
  }

  constructor() {
    this.artyom = new Artyom();
    this.initArtyom();
  }
}
