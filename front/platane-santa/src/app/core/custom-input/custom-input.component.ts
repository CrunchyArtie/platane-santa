import {Component, Input, OnInit} from '@angular/core';
import {ControlContainer, FormControl, FormGroup, FormGroupDirective} from '@angular/forms';

@Component({
  selector: 'app-custom-input',
  templateUrl: './custom-input.component.html',
  styleUrls: ['./custom-input.component.scss'],
  viewProviders: [
    {
      provide: ControlContainer,
      useExisting: FormGroupDirective
    }
  ]
})
export class CustomInputComponent implements OnInit {
  @Input() public label!: { key: string, value: string };
  @Input() public control!: FormControl
  @Input() public type: string = 'text';
  @Input() public errorMessages!: { [key: string]: string };
  @Input() public hint?: string;
  public shouldHide = true;

  ngOnInit(): void {
  }

  public getFormGroup(): FormGroup<any> {
    return this.control.parent! as FormGroup<any>;
  }

  public getErrors() {
    return Object.keys(this.control.errors!)
      .map((key) => {
        return this.errorMessages[key];
      });
  }
}
