import {AfterViewInit, Component, ElementRef, inject, ViewChild, ViewEncapsulation} from '@angular/core';
import {AuthenticationService} from '../../services/authentication.service';
import {combineLatest, filter, map, Observable} from 'rxjs';
import {RawUserData} from '../../models/user';
import {RawImageData} from "../../models/image";
import {environment} from "../../../environments/environment";
import {ImageModeService} from "../../services/image-mode.service";
import {SCRATCH_TYPE, ScratchCard} from "scratchcard-js";
import {SantaJokeTargetService} from "../../services/santa-joke-target.service";

const IMAGE_ENDPOINT = '/images';

@Component({
  selector: 'app-resolve-page',
  templateUrl: './resolve-page.component.html',
  styleUrls: ['./resolve-page.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class ResolvePageComponent implements AfterViewInit {

  @ViewChild('scContainer') scContainer!: ElementRef;

  private imageModeService = inject(ImageModeService);
  private authenticationService = inject(AuthenticationService);
  private santaJokeTargetService = inject(SantaJokeTargetService);

  public active = false;
  public target$: Observable<RawUserData> = this.authenticationService
    .user$
    .pipe(
      filter(user => !!user),
      map(user => user!.target)
    )
  public isImageMode$ = this.imageModeService.isImageMode$;

  ngAfterViewInit(): void {
    combineLatest([this.target$, this.santaJokeTargetService.santaJokeTarget$]).subscribe(([target, fakeTarget]) => {
      const appliedName = fakeTarget ? fakeTarget : target.name;
      console.log('resolve-page.component::39::qzemfijqzme', {target, fakeTarget, appliedName});
      const sc = new ScratchCard("#js--sc--container", <any>{
        scratchType: SCRATCH_TYPE.LINE,
        brushSrc: '',
        containerWidth: 300,
        containerHeight: 200,
        imageForwardSrc: '/assets/card.jpg',
        imageBackgroundSrc: '',
        htmlBackground: `<div class="inner_html"><p>${appliedName}</p></div>`,
        clearZoneRadius: 30,
        nPoints: 50,
        pointSize: 4,
        enabledPercentUpdate: true,
        percentToFinish: 99, // enabledPercentUpdate must to be true
        callback: function () {
        }
      })

      sc.init().then(() => {
        console.info('Scratch card initialized');
      }).catch((error) => {
        console.error('Failed to initialize scratch card', error);
      });
    });
  }

  getImagePath(image: RawImageData) {
    return environment.apiBaseUrl + IMAGE_ENDPOINT + '/' + image.id;
  }
}
