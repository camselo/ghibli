import { Component, OnInit } from '@angular/core';
import { Movie } from './movie';
import { MovieService } from './movie.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent implements OnInit {
  movies : Movie[];
  error : '';
  success : String;
  movie : any;
  movie2 : any;
  search : any;

  constructor(private movieService: MovieService){
    this.movie = new Movie('', '', '', '', '', 0);
    this.movie2 = new Movie('', '', '', '', '', 0);
  }

  ngOnInit(){
    this.getMovies();
  }

  getMovies() : void {
    this.movieService.getAll().subscribe(
      (res: Movie[]) => {
        this.movies = res;
      },
      (err) => {
        this.error = err;
      }
    );
  }

  // getMovie(g) : void {
  //   this.movieService.getOne(g).subscribe(
  //     (res: Movie) => {
  //       this.movie2 = res;
  //       this.search = 'Ok';
  //     },
  //     (err) => {
  //       this.error = err;
  //     }
  //   );
  // }

  addMovie(f) {
    console.log(f);
    this.error = '';
    this.success = '';

    this.movieService.store(this.movie)
      .subscribe(
        (res: Movie[]) => {
          this.movie = res;

          this.success = 'Added successfully';

          f.reset();
        },
        (err) => this.error = err
      );
  }
}
