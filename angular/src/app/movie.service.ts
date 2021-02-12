import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

import { Movie } from './movie';

@Injectable({
  providedIn: 'root'
})

export class MovieService {
  baseUrl = 'http://localhost/2020/repositorios/ghibli/angular/api';
  movies : Movie[];

  constructor(private http: HttpClient) {}
  movie : Movie;

  getAll(): Observable<Movie[]> {
    return this.http.get(`${this.baseUrl}/movie`).pipe(
      map((res) => {
        this.movies = res['data'];
        return this.movies;
      }
      ),
      catchError(this.handleError));
  }

  // getOne(id: any): Observable<Movie> {
  //   console.log(id.value);
  //   return this.http.get(`${this.baseUrl}/movie`, {params: id.value}).pipe(
  //   map((res) => {
  //     console.log(res['solo']);
  //     this.movie = res['solo'];
  //     console.log(this.movie);
  //     return this.movie;
  //   }
  //   ), 
  //   catchError(this.handleError));
  // }

  private handleError(error: HttpErrorResponse){
    console.log(error);
    return throwError(`Error: ${error.message}`);
  }

  store(movie: Movie): Observable<Movie[]> {
    console.log(movie)
    return this.http.post(`${this.baseUrl}/movie`, { data: movie })
      .pipe(map((res) => {
        this.movies.push(res['data']);
        return this.movies;
      }
      ),
      catchError(this.handleError));
  }
}
