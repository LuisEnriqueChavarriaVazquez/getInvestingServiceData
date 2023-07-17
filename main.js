/*
 * main.js
 * Envolvente en electron para hacer proyecto portable.
 * 
 * Copyright (C) 2017 Ricardo Quezada Figueroa
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */

const {app, BrowserWindow} = require('electron')
var sys = require('util')
var exec = require('child_process').exec;
const ipcMain = require('electron').ipcMain
var child;

function createWindow () {

	win = new BrowserWindow({
		width: 1200, height: 700,
		icon: "imagenes/icono.png",
		autoHideMenuBar: true,
		backgroundColor: "#ffffff",
		center: true
	})

	win.loadURL(`http://localhost:7050/resources/app/index.php`)
	win.on('closed', () => {
		if (process.platform === 'win32')
			exec('taskkill /F /IM php.exe')
		else
			child.kill()
		win = null
	})
}

ipcMain.on('load-page', (event, arg) => {
	win.loadURL(arg);
});
	
if (process.platform === 'win32') {

	/* Ejecución en windows */
	child = exec("resources\\app\\php-server\\php -c resources\\app\\php-server\\php.ini -S localhost:7050", function (error, stdout, stderr) {
	    console.log('stdout: ' + stdout)
	    console.log('stderr: ' + stderr)
	    if (error !== null) {
		console.log('exec error: ' + error);
	    }
	})

} else {
	
	/* Ejecución en linux o en mac */
	child = exec("php -S localhost:7050", function (error, stdout, stderr) {
	    console.log('stdout: ' + stdout)
	    console.log('stderr: ' + stderr)
	    if (error !== null) {
		console.log('exec error: ' + error);
	    }
	})
	
}

app.on('ready', createWindow)
app.on('window-all-closed', () => {
	app.quit()
})
