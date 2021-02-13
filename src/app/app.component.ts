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
  search : any;

  constructor(private movieService: MovieService){
    this.movie = new Movie();
  }

  ngOnInit(){
    this.getMovies();
  }

  getMovies() : void {
    this.movieService.getAll().subscribe(
      (res: Movie[]) => {
        this.movies = res;
        this.search = null;
      },
      (err) => {
        this.error = err;
      }
    );
  }

  getMovie(f) : void {
    this.error = '';
    this.success = '';
    this.movieService.getOne(f).subscribe(
      (res: Movie[]) => {
        this.movies = res;
        
        this.search = 'ok';
      },
      (err) => {
        this.error = err;
      }
    );
  }

  addMovie(f) {
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
