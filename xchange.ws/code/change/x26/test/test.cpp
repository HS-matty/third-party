
#include <conio.h>
#include <stdio.h>
#include <math.h>
#include <stdlib.h>
#include <string.h>



void	main(void){

	FILE*	ff;
	char	a[10];
	gets(a);
	printf("your string is %s",a);
	
	ff = fopen("test.txt","w+");
	fclose(ff);








}