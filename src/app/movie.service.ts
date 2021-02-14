import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';

import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';

import { Movie } from './movie';

@Injectable({
  providedIn: 'root'
})

export class MovieService {
  baseUrl = 'https://ghibli-movies.000webhostapp.com/api/v1';
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

  getOne(id: any): Observable<Movie> {  
    return this.http.get(`${this.baseUrl}/movie`, {params: id.value}).pipe(
    map((res) => {
      this.movie = res['data'];
      return this.movie;
    }
    ), 
    catchError(this.handleError));
  }

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
