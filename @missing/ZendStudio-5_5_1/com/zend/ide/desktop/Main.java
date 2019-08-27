/**
 * Zend Studio 5.5.1
 *
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @author Unknown_Hero
 * @seen  HS-matty (byqdes@gmail.com) (28-08-2019;00:04)
 *
 */


package com.zend.ide.desktop;

import com.zend.ide.desktop.b.b;
import com.zend.ide.desktop.b.k;
import com.zend.ide.util.c.h;
import java.io.File;


// hs-matty: seems  someone has a lot of problems in case of not_sharing real sources..

public class Main
{
  private static File a = new File(b.i, "loadingFlag");

  public static void main(String[] paramArrayOfString)
  {
    bm.b();
    boolean bool = b();
    a(paramArrayOfString, bool);
  }

  private static void a(String[] paramArrayOfString, boolean paramBoolean)
  {
    l locall = new l(paramArrayOfString);
    boolean bool1 = locall.c();
    boolean bool2 = locall.d();
    paramBoolean = bool2 ? false : paramBoolean;
    m[] arrayOfm = locall.b();
    Object localObject1;
    if (arrayOfm != null)
      for (int i = 0; i < arrayOfm.length; i++)
      {
        localObject1 = arrayOfm[i];
        System.setProperty(((m)localObject1).a, ((m)localObject1).b);
      }
    k localk = new k(locall);
    if (paramBoolean)
      paramBoolean = a(localk);
    if (!paramBoolean)
    {
      a.deleteOnExit();
      localObject1 = cj.h();
      synchronized (localObject1)
      {
        boolean bool3 = locall.e() == null;
        ((cj)localObject1).a(bool3, bool1);
      }
      a.delete();
      h.c().a(5);
      paramBoolean = localk.d();
    }
    if (paramBoolean)
      localk.f();
    localk.e();
  }

  private static boolean b()
  {
    boolean bool = false;
    try
    {
      int i = !a.createNewFile() ? 1 : 0;
      if ((i != 0) && (System.currentTimeMillis() - a.lastModified() > 60000L))
        i = 0;
      if (i != 0)
      {
        bool = true;
      }
      else
      {
        bool = new File(b.j).exists();
        if (bool)
          a.delete();
      }
    }
    catch (Exception localException)
    {
    }
    return bool;
  }

  private static boolean a(k paramk)
  {
    boolean bool = false;
    for (int i = 0; (i < 10) && (!(bool = paramk.d())); i++)
      try
      {
        synchronized (paramk)
        {
          paramk.wait(1000L);
        }
      }
      catch (InterruptedException localInterruptedException)
      {
      }
    return bool;
  }
}

/* Location:           C:\Program Files\Zend\ZendStudio-5.5.1\bin\ZendIDE.jar
 * Qualified Name:     com.zend.ide.desktop.Main
 * JD-Core Version:    0.6.0
 */