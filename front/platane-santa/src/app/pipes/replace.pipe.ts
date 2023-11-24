import {Pipe, PipeTransform} from '@angular/core';

@Pipe({
  name: 'replace'
})
export class ReplacePipe implements PipeTransform {

  transform(value: string, ...args: string[]): unknown {
    if (args.length % 2 !== 0) {
      throw new Error('Replace pipe must have an even number of arguments');
    }

    for (let i = 0; i < args.length; i += 2) {
      value = value.replace(args[i], args[i + 1]);
    }

    return value
  }

}
